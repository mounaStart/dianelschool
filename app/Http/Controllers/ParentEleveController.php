<?php

namespace App\Http\Controllers;

use App\Models\ParentEleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentEleveController extends Controller
{

    public function index()
    {
        $parents = ParentEleve::all();
        return view('parents.index', compact('parents'));
    }

    public function create()
    {
        return view('parents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'telephone' => 'required',
        ]);

        ParentEleve::create($request->all());

        return redirect()->route('parents.index')->with('success', 'Parent ajouté avec succès.');
    }

    public function edit(ParentEleve $parent)
    {
        return view('parents.edit', compact('parent'));
    }

    public function update(Request $request, ParentEleve $parent)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'telephone' => 'required',
        ]);

        $parent->update($request->all());

        return redirect()->route('parents.index')->with('success', 'Parent mis à jour avec succès.');
    }

    public function destroy(ParentEleve $parent)
    {
        $parent->delete();
        return redirect()->route('parents.index')->with('success', 'Parent supprimé.');
    }

    public function show(ParentEleve $parent)
{
    $eleves = $parent->eleves; // on récupère les enfants du parent
    return view('parents.show', compact('parent', 'eleves'));
}
public function notes()
{
    $user = Auth::user();

    // Trouve le parent correspondant à l'utilisateur connecté
    $parent = ParentEleve::where('user_id', $user->id)->first();

    if (!$parent) {
        return redirect()->route('parents.dashboard')->with('error', 'Parent non trouvé.');
    }

    // Récupère les enfants avec leurs notes et les matières liées
    $enfants = $parent->enfants()->with(['notes.matier', 'classe'])->get();

    return view('parent_portal.notes', compact('enfants'));
}

 
public function dashboard()
{
    $parent = Auth::user(); // utilisateur connecté
    $parentEleve = ParentEleve::where('user_id', $parent->id)->first();

    $enfants = $parentEleve->enfants()->with('classe')->get();
    $nombreEnfants = $enfants->count();

    return view('parent_portal.dashboard', compact('enfants', 'nombreEnfants'));
}

    
}
