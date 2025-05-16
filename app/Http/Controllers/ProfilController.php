<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    //
    public function show()
    {
        $user = auth()->user();
        return view('profil.show', compact('user'));
    }
    public function edit()
    {
        $user = auth()->user();
        return view('profil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->route('profil.show')->with('success', 'Profil mis à jour avec succès.');
    }


}
