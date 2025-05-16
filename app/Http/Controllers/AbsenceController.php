<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Eleve;
use Illuminate\Http\Request;

 
class AbsenceController extends Controller
{
    //

public function index()
{
    $absences = Absence::with('eleve')->latest()->get();
    return view('absences.index', compact('absences'));
}

 
public function create()
{
    $classes = \App\Models\Classe::all();
    return view('absences.create', compact('classes'));
}

public function store(Request $request)
{
    $request->validate([
        'eleve_id' => 'required|exists:eleves,id',
        'date' => 'required|date',
        'type' => 'required|in:absence,retard',
        'motif' => 'nullable|string',
    ]);

    Absence::create($request->all());

    return redirect()->route('absences.index')->with('success', 'Absence/retard enregistré avec succès.');
}
/**
 * The function `getElevesByClasse` retrieves a list of students based on the provided class ID and
 * returns them as a JSON response.
 * 
 * @param classe_id The `getElevesByClasse` function is a PHP function that retrieves a list of
 * students (Eleves) based on the provided `classe_id`. The `classe_id` parameter is used to filter the
 * students belonging to a specific class.
 * 
 * @return A JSON response containing a collection of students (Eleves) belonging to the specified
 * class ID.
 */

public function getElevesByClasse($classe_id)
{
    $eleves = \App\Models\Eleve::where('classe_id', $classe_id)->get();
    return response()->json($eleves);
}

 

public function storeMultiple(Request $request)
{
    $date = $request->input('date');
    $classeId = $request->input('classe_id');
    $absents = (array) $request->input('absents', []); // ← la clé ici

    foreach ($absents as $eleveId) {
        \App\Models\Absence::create([
            'eleve_id' => $eleveId,
            'date' => $date,
            'type' => 'absence'
        ]);
    }

    return redirect()->route('absences.index')->with('success', 'Absences enregistrées avec succès.');
}


}
