<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\Classe;
use App\Models\Cours;
use App\Models\EmploiDuTemps;
use App\Models\Salle;
use App\Models\Enseignement;
use App\Models\Matier;
class EvaluationController extends Controller
{
    public function index()
    {
        $evaluations = Evaluation::all();
        return view('evaluations.index', compact('evaluations'));
    }
     // Formulaire de création d'un evauation
     public function create()
     {
         $classes = Classe::all();
         $cours = Cours::all();
         $matiers = Matier::all();
         $salles = Salle::all();
         return view('evaluations.create', compact('classes', 'cours', 'salles'));
     }
 

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'date' => 'required|date',
             'classe_id' => 'required|exists:classes,id', 
            'matiere_id' => 'required|exists:matiers,id'
        ]);

        Evaluation::create($request->all());

        return redirect()->route('evaluations.index')->with('success', 'Évaluation ajoutée avec succès');
    }
    public function getMatieres($classe_id)
{
    // Récupérer les matières liées à la classe sélectionnée
    $matieres = Cours::where('classe_id', $classe_id)
                ->with('matiere')
                ->get();

    return response()->json($matieres);
}

}
