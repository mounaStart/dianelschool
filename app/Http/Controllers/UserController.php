<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Afficher la liste des utilisateurs
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        // Récupérer les rôles pour le formulaire
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

   // app/Http/Controllers/UserController.php

public function store(Request $request)
{
    // Valider les données d'entrée
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed', // Nécessite un champ password_confirmation
        'roles' => 'required|array', // Les rôles doivent être un tableau d'IDs
    ],
    [
        'name.required' => 'Le nom est obligatoire.',
        'email.required' => 'L\'adresse email est obligatoire.',
        'email.email' => 'Veuillez fournir une adresse email valide.',
        'email.unique' => 'Cette adresse email est déjà utilisée.',
        'password.required' => 'Le mot de passe est obligatoire.',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        'roles.required' => 'Vous devez choisir au moins un rôle.',
    ]
);

    // Créer un nouvel utilisateur
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Assigner les rôles à l'utilisateur dans la table de jointure roles_users
    $user->roles()->sync($request->roles);

    // Rediriger avec un message de succès
    return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
}


    public function edit(User $user)
    {
        // Récupérer les rôles pour le formulaire d'édition
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // Valider les données d'entrée
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array'
        ]);

        // Mettre à jour les informations de l'utilisateur
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        // Mettre à jour les rôles associés à l'utilisateur
        $user->roles()->sync($request->roles);

        // Rediriger vers la liste des utilisateurs
        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        // Supprimer l'utilisateur
        $user->delete();

        // Rediriger avec un message de succès
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
