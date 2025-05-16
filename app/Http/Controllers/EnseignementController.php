<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Enseignement;
use App\Models\EmploiDuTemps;
use App\Models\Classe;
use Illuminate\Support\Facades\Auth;
class EnseignementController extends Controller
{
    //
    public function index() {
        $Enseignements = Enseignement::all();
        return view('Enseignements.index', compact('Enseignements'));
    }

   
    public function create() {
        return view('Enseignements.create');
    }
    //Store enseignenet 

    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            // Champs pour l'élève
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'lieux_naissance' => 'required|string|max:255',
            'sexe' => 'required',
            'nationalite' => 'required|string|max:255',
            'telephone' => 'required|numeric',
            'email' => 'required|email|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'diplome' => 'required|string|max:255',
            'salaire' => 'required|numeric',
           
            
            
            'type_contrat' => 'required',
            'debut_contrat' => 'required|date',
            'fin_contrat' => 'required|date'
           
             
        ]);
    
        // Gestion de la photo
        $photoPath = $request->hasFile('photo') ? $request->file('photo')->store('photos', 'public') : null;
    
         
         
        // Création de l'enseignenet
        Enseignement::create([

            
            'nom' => $request->nom,
             
            'prenom' => $request->prenom,
            'sexe' => $request->sexe,

            'date_naissance' => $request->date_naissance,
            'lieux_naissance' => $request->lieux_naissance,
            'telephone' => $request->telephone,

            'nationalite' => $request->nationalite,
            'email' => $request->email,
            'diplome' => $request->diplome,

            'type_contrat' => $request->type_contrat,
            'debut_contrat' => $request->debut_contrat,
            'Fin_contrat' => $request->fin_contrat,

            'salaire' => $request->salaire,
            'photo' => $photoPath, // Stocke le chemin de la photo
        ]);
    
        return redirect()->route('enseignements.index')->with('success', 'Enseignement inscrit avec succès.');
    }
     // Supprimer une matière
     public function destroy($id)
     {
         $enseignement = Enseignement::findOrFail($id);
         $enseignement->delete();
 
         return redirect()->route('enseignements.index')->with('success', 'Matière supprimée avec succès');
     }
     // Afficher le formulaire d'édition d'une matière
     public function edit($id)
     {
         $enseignement = Enseignement::findOrFail($id);
         return view('enseignements.edit', compact('enseignement'));
     }
 
     // Mettre à jour un Enseignement existant
     public function update(Request $request, $id)
     {
         $request->validate([
             'name' => 'required|string|max:255',
         ]);
 
         $enseignement = Enseignement::findOrFail($id);
         $enseignement->update([
             'nom' => $request->name,
         ]);
 
         return redirect()->route('enseignements.index')->with('success', 'Matière mise à jour avec succès');
     }
    
     public function dashboard()
{
    $enseignant = Auth::user();
$enseignant = auth()->user()->enseignement;
$matieres = $enseignant->cours()->with('matiere')->get()->pluck('matiere')->unique('id');
 
    // Récupère les cours liés à l’enseignant via la table EmploiDuTemps
    $emploi = EmploiDuTemps::where('enseignant_id', $enseignant->id)->get();
 
    // Récupère les classes uniques
    $classes = $emploi->pluck('classe')->unique('id');

    // Récupère les matières via les cours liés à emploi du temps
    $matieres = $emploi->map(function ($e) {
        return $e->cours->matiere ?? null;
    })->filter()->unique('id');

    return view('enseignants.dashboard', compact('enseignant', 'classes', 'matieres'));
}
 

public function emploiDuTemps()
{
    $user = Auth::user();

    // Récupérer l'enseignant lié à l'utilisateur connecté
    $enseignant = $user->enseignement;

    if (!$enseignant) {
        abort(403, 'Aucun enseignant associé à cet utilisateur.');
    }

    // Charger les emplois du temps liés à cet enseignant
    $emplois = EmploiDuTemps::with(['classe', 'cours', 'salle'])
        ->where('enseignant_id', $enseignant->id)
        ->orderBy('date')
        ->orderBy('heure_debut')
        ->get();

    return view('enseignants.emploi', compact('emplois'));
}

    public function mesClasses()
    {
        // récupère les classes de l’enseignant connecté
        return view('enseignants.enseignements');
    }

    public function matieres()
    {
        // récupère les matières de l’enseignant connecté
        return view('enseignants.matieres');
    }
    public function classes()
{
    // Récupérer l'enseignant connecté
    $enseignant = Auth::user();

    // Récupérer ses classes (via relation s’il y en a, sinon adapter)
    $classes = Classe::where('enseignant_id', $enseignant->id)->get();

    // Afficher la vue avec les classes
    return view('enseignants.classes', compact('classes'));
}
    

}
