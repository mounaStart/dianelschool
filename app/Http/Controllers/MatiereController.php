<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matier;
class MatiereController extends Controller
{
    //
     // Afficher la liste des matières
     public function index()
     {
         $matiers = Matier::all();
         return view('matiers.index', compact('matiers'));
     }
 
     // Afficher le formulaire de création d'une nouvelle matière
    // Afficher le formulaire de création d'une nouvelle matière
        public function create()
        {
            return view('matiers.create');
        }

        // Enregistrer une nouvelle matière
        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'coefficient' => 'required|numeric|min:1',
            ]);

            Matier::create([
                'nom' => $request->name,
                'coefficient' => $request->coefficient,
            ]);

            return redirect()->route('matiers.index')->with('success', 'Matière ajoutée avec succès');
        }

 
     // Afficher le formulaire d'édition d'une matière
     public function edit($id)
     {
         $matier = Matier::findOrFail($id);
         return view('matiers.edit', compact('matier'));
     }
 
     // Mettre à jour une matière existante
     public function update(Request $request, $id)
     {
         $request->validate([
             'name' => 'required|string|max:255',
         ]);
 
         $matier = Matier::findOrFail($id);
         $matier->update([
             'nom' => $request->name,
         ]);
 
         return redirect()->route('matiers.index')->with('success', 'Matière mise à jour avec succès');
     }
 
     // Supprimer une matière
     public function destroy($id)
     {
         $matier = Matier::findOrFail($id);
         $matier->delete();
 
         return redirect()->route('matiers.index')->with('success', 'Matière supprimée avec succès');
     }
}
