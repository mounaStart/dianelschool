<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Matier;
use App\Models\Cours;
use App\Models\Enseignement;
use Illuminate\Http\Request;

class ClasseCoursController extends Controller
{
    public function index()
    {
        $classes = Classe::all();
        return view('classes.index', compact('classes'));
    }

    public function manageCours($id)
    {
        $classe = Classe::findOrFail($id);
        $matieres = Matier::all();
        $enseignants = Enseignement::all();
        $cours = $classe->cours()->with('matiere', 'enseignement')->get();

        return view('classes.manage-cours', compact('classe', 'matieres', 'enseignants', 'cours'));
    }

    public function updateCours(Request $request, $id)
    {
        $classe = Classe::findOrFail($id);
        foreach ($request->cours as $matiereId => $enseignementId) {
            $cours = Cours::updateOrCreate(
                ['classe_id' => $classe->id, 'matiere_id' => $matiereId],
                ['enseignement_id' => $enseignementId]
            );
        }

        return redirect()->route('classes.index')->with('success', 'Cours mis à jour avec succès.');
    }
}

