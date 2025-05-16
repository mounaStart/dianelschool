<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Eleve;
use App\Models\Evaluation;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Classe ;
class NoteController extends Controller
{
    public function index()
{ 
    $eleves = Eleve::with('notes.evaluation.matiere')->get();
    $evaluations = Evaluation::all();
    $classes = Classe::all(); // Ajout de cette ligne

    return view('notes.index', compact('eleves', 'evaluations', 'classes'));
} 


public function store(Request $request)
{
    $request->validate([
        'evaluation_id' => 'required|exists:evaluations,id',
        'notes' => 'required|array', // Vérifie que 'notes' est bien un tableau
        'notes.*' => 'nullable|numeric|min:0|max:20' // Chaque note doit être un nombre entre 0 et 20
    ]);

    foreach ($request->notes as $eleve_id => $note) {
        if ($note !== null) { // Ignorer les notes vides
            Note::updateOrCreate(
                ['eleve_id' => $eleve_id, 'evaluation_id' => $request->evaluation_id,'classe_id' => $request->classe_id],
                ['note' => $note]
            );
        }
    }

    return redirect()->route('notes.index')->with('success', 'Notes enregistrées avec succès');
}


public function genererBulletinPDF($id)
{
    $eleve = Eleve::with('notes.evaluation.matiere')->findOrFail($id);

    $matieres = [];
    $moyenneGenerale = 0;
    $totalCoefficients = 0;

    // Calcul des moyennes par matière
    foreach ($eleve->notes as $note) {
        $matiereId = $note->evaluation->matiere->id;
        $matiereNom = $note->evaluation->matiere->nom;
        $coefficient = $note->evaluation->matiere->coefficient ?? 1;

        if (!isset($matieres[$matiereId])) {
            $matieres[$matiereId] = [
                'nom' => $matiereNom,
                'notes' => [],
                'coefficient' => $coefficient
            ];
        }

        $matieres[$matiereId]['notes'][] = $note->note;
    }

    // Calcul des moyennes par matière et de la moyenne générale
    foreach ($matieres as &$matiere) {
        $sommeNotes = array_sum($matiere['notes']);
        $nombreNotes = count($matiere['notes']);
        $moyenne = $nombreNotes > 0 ? $sommeNotes / $nombreNotes : 0;
        $matiere['moyenne'] = number_format($moyenne, 2);

        // Moyenne générale pondérée
        $moyenneGenerale += $moyenne * $matiere['coefficient'];
        $totalCoefficients += $matiere['coefficient'];
    }

    $moyenneGenerale = $totalCoefficients > 0 ? $moyenneGenerale / $totalCoefficients : 0;
    $moyenneGenerale = number_format($moyenneGenerale, 2);

    $pdf = Pdf::loadView('notes.bulletin', compact('eleve', 'matieres', 'moyenneGenerale'));

    return $pdf->download('bulletin_'.$eleve->nom.'.pdf');
}
// bultin tous 
public function genererTousLesBulletinsPDF()
{
    $eleves = Eleve::with('notes.evaluation.matiere')->get();

    $bulletins = [];

    foreach ($eleves as $eleve) {
        $matieres = [];
        $totalNotes = 0;
        $totalCoef = 0;

        // Organisation des notes par matière
        foreach ($eleve->notes as $note) {
            $matiereNom = $note->evaluation->matiere->nom;
            $coefficient = $note->evaluation->matiere->coef ?? 1;

            // Regrouper les notes par matière
            if (!isset($matieres[$matiereNom])) {
                $matieres[$matiereNom] = [
                    'nom' => $matiereNom,
                    'notes' => [],
                    'coefficient' => $coefficient,
                    'moyenne' => 0
                ];
            }

            $matieres[$matiereNom]['notes'][] = $note->note;
        }

        // Calcul des moyennes par matière et moyenne générale
        foreach ($matieres as &$matiere) {
            $sommeNotes = array_sum($matiere['notes']);
            $nombreNotes = count($matiere['notes']);
            $matiere['moyenne'] = $nombreNotes > 0 ? round($sommeNotes / $nombreNotes, 2) : 0;

            // Calcul pour la moyenne générale
            $totalNotes += $matiere['moyenne'] * $matiere['coefficient'];
            $totalCoef += $matiere['coefficient'];
        }

        $moyenneGenerale = $totalCoef > 0 ? round($totalNotes / $totalCoef, 2) : 0;

        $bulletins[] = [
            'eleve' => $eleve,
            'matieres' => $matieres,
            'moyenneGenerale' => $moyenneGenerale
        ];
    }

    // Génération du PDF avec tous les bulletins
    $pdf = Pdf::loadView('notes.bulletins_tous', compact('bulletins'));
    
    return $pdf->download('bulletins_tous.pdf');
}




    //Les notes d'une classe
    public function getNotes(Request $request)
    {
        $classeId = $request->input('classe_id');
    
        if (!$classeId) {
            return response()->json(['message' => 'Classe non sélectionnée'], 400);
        }
    
        $eleves = Eleve::where('classe_id', $classeId)->with('notes')->get();
    
        // Vérifier si on obtient bien les élèves et notes
        if ($eleves->isEmpty()) {
            return response()->json(['message' => 'Aucune note trouvée pour cette classe.'], 200);
        }
    
        return view('notes.partials.notes_classe', compact('eleves'))->render();
    }
    

public function create($evaluationId)
{
    $evaluation = Evaluation::with('matiere')->findOrFail($evaluationId);
    $eleves = Eleve::where('classe_id', $evaluation->classe_id)->get();

    return view('notes.create', compact('evaluation', 'eleves'));
}


}
