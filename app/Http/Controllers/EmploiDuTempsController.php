<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\Cours;
use App\Models\EmploiDuTemps;
use App\Models\Salle;
use App\Models\Enseignement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EmploiDuTempsController extends Controller
{
    // Liste des emplois du temps
    public function index()
    {
        $emploisDuTemps = EmploiDuTemps::with(['classe', 'cours', 'salle', 'enseignement'])->get();
        return view('emplois-du-temps.index', compact('emploisDuTemps'));
    }

    // Formulaire de création d'un emploi du temps
    public function create()
    {
        $classes = Classe::all();
        $cours = Cours::with('matiere', 'enseignement')->get();
        $salles = Salle::all();
        return view('emplois-du-temps.create', compact('classes', 'cours', 'salles'));
    }

    public function store(Request $request)
    {
        // Assurez-vous que les heures sont dans le format `HH:mm`
        $request->merge([
            'heure_debut' => substr($request->heure_debut, 0, 5),
            'heure_fin' => substr($request->heure_fin, 0, 5),
        ]);
    
        // Valider les champs, y compris les heures
        $validated = $request->validate([
            'date' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i',
            'classe_id' => 'required|exists:classes,id',
            'cours_id' => 'required|exists:cours,id',
            'enseignant_id' => 'required|exists:enseignements,id',
            'salle_id' => 'required|exists:salles,id',
        ]);
    
        // Validation personnalisée pour vérifier que `heure_fin` > `heure_debut`
        if (strtotime($validated['heure_fin']) <= strtotime($validated['heure_debut'])) {
            return back()->withErrors(['heure_fin' => 'L\'heure de fin doit être supérieure à l\'heure de début.'])->withInput();
        }
    
        // Création de l'emploi du temps
        EmploiDuTemps::create($validated);
    
        return redirect()->route('emplois-du-temps.index')->with('success', 'Emploi du temps ajouté avec succès.');
    }
    
     
    // Formulaire d'édition
    public function edit($id)
    {
        $emploiDuTemps = EmploiDuTemps::findOrFail($id);
        $classes = Classe::all();
        $cours = Cours::with('matiere', 'enseignement')->get();
        $salles = Salle::all();
        return view('emplois-du-temps.edit', compact('emploiDuTemps', 'classes', 'cours', 'salles'));
    }
    


    // Mise à jour d'un emploi du temps
    public function update(Request $request, $id)
    {
        // Nettoyage des données pour garantir le bon format
        $request->merge([
            'heure_debut' => substr($request->heure_debut, 0, 5), // Prendre uniquement 'HH:MM'
            'heure_fin' => substr($request->heure_fin, 0, 5),
        ]);

        try {
            $validated = $request->validate([
                'date' => 'required|date',
                'heure_debut' => 'required|date_format:H:i',
                'heure_fin' => 'required|date_format:H:i',
                'classe_id' => 'required|exists:classes,id',
                'cours_id' => 'required|exists:cours,id',
                'enseignant_id' => 'required|exists:enseignements,id',
                'salle_id' => 'required|exists:salles,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
        // Validation personnalisée pour vérifier que `heure_fin` > `heure_debut`
        if (strtotime($validated['heure_fin']) <= strtotime($validated['heure_debut'])) {
            return back()->withErrors(['heure_fin' => 'L\'heure de fin doit être supérieure à l\'heure de début.'])->withInput();
        }
    
        $emploiDuTemps = EmploiDuTemps::findOrFail($id);
        $emploiDuTemps->update($validated);

        return redirect()->route('emplois-du-temps.index')->with('success', 'Emploi du temps mis à jour avec succès.');
    }
    // Suppression d'un emploi du temps
    public function destroy($id)
    {
        $emploiDuTemps = EmploiDuTemps::findOrFail($id);
        $emploiDuTemps->delete();

        return redirect()->route('emplois-du-temps.index')->with('success', 'Emploi du temps supprimé avec succès.');
    }
    // impression 
    public function print($id)
    {
        $emploiDuTemps = EmploiDuTemps::with('classe', 'cours.matiere', 'salle', 'cours.enseignement')->findOrFail($id);
    
        return view('emplois-du-temps.print', compact('emploiDuTemps'));
    }
    public function printClassSchedule($id)
{
    // Charger la classe avec ses emplois du temps et les relations nécessaires
    $classe = Classe::with([
        'emploisDuTemps.cours.matiere',
        'emploisDuTemps.salle',
        'emploisDuTemps.cours.enseignement',
    ])->findOrFail($id);

    // Retourner une vue avec les données de la classe et ses emplois du temps
    return view('classes.emplois-du-temps.print', compact('classe'));
}


}

