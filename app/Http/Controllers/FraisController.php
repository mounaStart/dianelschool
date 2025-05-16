<?php

namespace App\Http\Controllers;

use App\Models\FraisScolaire;
use App\Models\Classe ;
use Illuminate\Http\Request;

class FraisController extends Controller
{
    // 🔹 Afficher la liste des frais scolaires
    public function index()
    {
        $frais = FraisScolaire::all();
        return view('frais.index', compact('frais'));
    }

    // 🔹 Afficher le formulaire d'ajout d'un frais scolaire
    public function create()
    {
        $classes = Classe::all();  // Récupérer toutes les classes
        return view('frais.create', compact('classes'));
    }
    

    // 🔹 Enregistrer un nouveau frais scolaire
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0',
            'classe_id' => 'required|exists:classes,id', // Validation pour classe_id
            'description' => 'nullable|string',
        ]);

        FraisScolaire::create([
            'nom' => $request->nom,
            'montant' => $request->montant,
            'classe_id' => $request->classe_id,
            'description' => $request->description,
        ]);

        return redirect()->route('frais.index')->with('success', 'Frais scolaire ajouté avec succès.');
    }


    // 🔹 Afficher le formulaire de modification d'un frais scolaire
    public function edit(FraisScolaire $frais)
    {
        return view('frais.edit', compact('frais'));
    }

    // 🔹 Mettre à jour un frais scolaire
    public function update(Request $request, FraisScolaire $frais)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $frais->update($request->all());

        return redirect()->route('frais.index')->with('success', 'Frais scolaire mis à jour avec succès.');
    }

    // 🔹 Supprimer un frais scolaire
    public function destroy(FraisScolaire $frais)
    {
        $frais->delete();

        return redirect()->route('frais.index')->with('success', 'Frais scolaire supprimé avec succès.');
    }
}
