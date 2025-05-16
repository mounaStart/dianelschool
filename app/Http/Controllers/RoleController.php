<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// App\Http\Controllers\RoleController.php

 

use App\Models\Role;
use App\Models\User;
 

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:roles,name']);
        Role::create($request->only('name'));
        return redirect()->route('roles.index')->with('success', 'Rôle créé avec succès.');
    }

    public function assign(Request $request, User $user)
    {
        $request->validate(['role_id' => 'required|exists:roles,id']);
        $user->roles()->attach($request->role_id);
        return redirect()->back()->with('success', 'Rôle assigné avec succès.');
    }
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rôle supprimé avec succès.');
    }
    public function update(Request $request, Role $role)
    {
        // Valider les données du formulaire
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Mettre à jour le rôle avec les nouvelles données
        $role->update([
            'name' => $request->input('name'),
        ]);

        // Rediriger après la mise à jour avec un message de succès
        return redirect()->route('roles.index')->with('success', 'Rôle mis à jour avec succès.');
    }

    // ...
}












