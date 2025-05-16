<?php

namespace App\Http\Controllers;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;

class AnneeScolaireController extends Controller
{
    public function index()
    {
        $anneesScolaires = AnneeScolaire::all();
        return view('anneés_scolaire.index', compact('anneesScolaires'));
    }

    // Exemple de méthode pour créer une nouvelle année scolaire
    public function create(Request $request)
    {
        $request->validate([
            'annee_scolaire' => 'required|regex:/^\d{4}-\d{4}$/|unique:annee_scolaires,annee_scolaire',
        ]);

        AnneeScolaire::create([
            'annee_scolaire' => $request->annee_scolaire,
        ]);

        return redirect()->route('annees_scolaires.index');
    }


}
