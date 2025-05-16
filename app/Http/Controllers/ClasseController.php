<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    public function index() {
        $classes = Classe::all();
        return view('classes.index', compact('classes'));
    }

    public function create() {
        return view('classes.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
        ]);

        Classe::create($request->all());
        return redirect()->route('classes.index')->with('success', 'Classe ajoutée avec succès.');
    }

    public function edit($id) {
        $classe = Classe::find($id);
        return view('classes.edit', compact('classe'));
    }

    public function update(Request $request, $id) {
        $classe = Classe::find($id);
        $classe->update($request->all());
        return redirect()->route('classes.index')->with('success', 'Classe mise à jour avec succès.');
    }

    public function destroy($id) {
        $classe = Classe::find($id);
        $classe->delete();
        return redirect()->route('classes.index')->with('success', 'Classe supprimée avec succès.');
    }

    public function imprimerEmploisDuTemps($id)
    {
        $classe = Classe::with('emploisDuTemps.cours.matiere', 'emploisDuTemps.salle', 'emploisDuTemps.enseignement')->findOrFail($id);

        // Vue dédiée à l'impression
        $pdf = \PDF::loadView('classes.print-classe', compact('classe'));

        // Retourne un téléchargement PDF
        return $pdf->download('emplois-du-temps-classe-' . $classe->id . '.pdf');
    }

    public function emploiDuTemps($id)
{
    $classe = Classe::with(['emploiDuTemps.cours.matiere', 'emploiDuTemps.salle', 'emploiDuTemps.cours.enseignement'])
        ->findOrFail($id);

    $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi','Samedi'];

    // Récupérer les emplois du temps et les regrouper par jour
    $emplois = $classe->emploiDuTemps()->get(); // Obtenez les emplois en tant que collection
    $emploiParJour = $emplois->groupBy(function ($emploi) {
        return \Carbon\Carbon::parse($emploi->date)->locale('fr')->dayName;
    });

    return view('classes.emploi_du_temps', compact('classe', 'jours', 'emploiParJour'));
}


}
