<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Eleve;
use App\Models\User;
use App\Models\Classe;
use App\Models\ParentEleve ;
use App\Exports\ElevesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AllDataExport;
use App\Models\Role;
class EleveController extends Controller
{

    public function index(Request $request)
    {
        $query = Eleve::query();
        $anneesScolaires = \App\Models\AnneeScolaire::all();
        $classes = \App\Models\Classe::all();
        $parents = \App\Models\ParentEleve::all();
        // Appliquer les filtres
        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }
        if ($request->filled('prenom')) {
            $query->where('prenom', 'like', '%' . $request->prenom . '%');
        }
        if ($request->filled('sexe')) {
            $query->where('sexe', $request->sexe);
        }
        if ($request->filled('nationalite')) {
            $query->where('nationalite', 'like', '%' . $request->nationalite . '%');
        }

        
        // Récupérer les résultats filtrés
        $eleves = $query->get();
    
        /* This line of code is fetching a paginated list of students (élèves) from the database where
        the 'suspendu' column is set to false. It is using the Eloquent ORM to query the 'Eleve'
        model and retrieve only the students who are not suspended. The results are then paginated
        with 10 students per page. */
        // $eleves = Eleve::where('suspendu', false)->paginate(10); // Pagination à 10 élèves par page
        return view('eleves.index', compact('eleves'),compact('anneesScolaires'),compact('classes') ,  compact('parents'));
    }
    public function create()
    {
        // Charger les classes pour la liste déroulante
        $classes = \App\Models\Classe::all();
        $parents = \App\Models\ParentEleve::all();
        $anneesScolaires = \App\Models\AnneeScolaire::all();

        return view('eleves.create',compact('anneesScolaires') ,compact('classes') ,  compact('parents'));
    }
  
public function store(Request $request)
{
    try {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            // Champs pour l'élève
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'numero_national' => 'nullable|numeric',
            'sexe' => 'required',
            'nationalite' => 'nullable|string|max:255',
            'date_naissance' => 'nullable|date',
            'lieux_naissance' => 'nullable|string|max:255',
            'classe_id' => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Champs pour le parent
            'nomParent' => 'required|string|max:255',
            'prenomParent' => 'required|string|max:255',
            'relation' => 'required|string|max:255',
            'telephone' => 'required|numeric',
            'email' => 'required|email|max:255|unique:users,email|unique:parent_eleves,email',
            // ↑ Validation unique pour les DEUX tables ↑
        ], [
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            // Messages personnalisés pour les autres champs...
        ]);

        // Gestion de la photo
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        // Création de l'utilisateur parent
        $user = User::create([
            'name' => $request->prenomParent . ' ' . $request->nomParent,
            'email' => $request->email,
            'password' => Hash::make('123456789'),
        ]);

        // Attribution du rôle "parent" à l'utilisateur
        $parentRole = Role::where('name', 'parent')->first();
        if (!$parentRole) {
            $parentRole = Role::create([
                'name' => 'parent',
                'guard_name' => 'web'
            ]);
        }
        $user->roles()->attach($parentRole->id);

        // Enregistrement du parent
        $parent = ParentEleve::create([
            'nom' => $request->nomParent,
            'prenom' => $request->prenomParent,
            'relation' => $request->relation,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'user_id' => $user->id,
        ]);

        // Création de l'élève en associant le parent
        Eleve::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'adresse' => $request->adresse,
            'numero_national' => $request->numero_national,
            'sexe' => $request->sexe,
            'nationalite' => $request->nationalite,
            'date_naissance' => $request->date_naissance,
            'lieux_naissance' => $request->lieux_naissance,
            'type_eleve' => $request->type_eleve,
            'moyen_transport' => $request->moyen_transport,
            'classe_id' => $request->classe_id,
            'annee_scolaire_id' => $request->annee_scolaire_id,
            'parent_id' => $parent->id,
            'photo' => $photoPath,
        ]);

        return redirect()->route('eleves.index')->with('success', 'Élève inscrit avec succès.');

    } catch (QueryException $e) {
        // Capturer l'erreur de violation de contrainte d'intégrité
        $errorCode = $e->errorInfo[1];
        
        if ($errorCode == 1062) { // Code d'erreur MySQL pour duplicate entry
            // Vérifier si l'erreur concerne l'email dans la table USERS
            if (str_contains($e->getMessage(), 'users_email_unique')) {
                return back()->withInput()->withErrors([
                    'email' => 'Cette adresse email est déjà utilisée pour un compte utilisateur.'
                ]);
            }
            
            // Vérifier si l'erreur concerne l'email dans la table PARENTS
            if (str_contains($e->getMessage(), 'parent_eleves_email_unique')) {
                return back()->withInput()->withErrors([
                    'email' => 'Cette adresse email est déjà utilisée par un parent.'
                ]);
            }
            
            // Gérer d'autres contraintes uniques si nécessaire
            if (str_contains($e->getMessage(), 'autre_contrainte_unique')) {
                return back()->withInput()->withErrors([
                    'champ' => 'Message d\'erreur personnalisé.'
                ]);
            }
        }

        // Pour toutes les autres erreurs SQL
        Log::error('Erreur base de données lors de la création élève: ' . $e->getMessage());
        return back()->withInput()->withErrors([
            'general' => 'Une erreur inattendue s\'est produite. Veuillez réessayer.'
        ]);
    }
}
   
    // Detaille eleves 
    public function show($id)
    {
        $eleve = Eleve::findOrFail($id);
        return view('eleves.show', compact('eleve'));
    }

    public function suspend($id)
    {
        $eleve = Eleve::findOrFail($id);
        $eleve->suspendu = true; // Exemple de champ pour indiquer la suspension
        $eleve->save();

        return redirect()->back()->with('status', 'Élève suspendu avec succès.');
    }
    // Editer les eleves 
    public function edit($id)
    {
        $eleve = Eleve::findOrFail($id);
        $classes = Classe::all(); // Pour la liste des classes dans le formulaire
        return view('eleves.edit', compact('eleve', 'classes'));
    }
    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'numero_national' => 'required|numeric',
            'sexe' => 'required',
            'nationalite' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'lieux_naissance' => 'required|string|max:255',
            'telephone1' => 'required|numeric',
            'telephone2' => 'nullable|numeric',
            'type_eleve' => 'required',
            'moyen_transport' => 'required',
            'parent_id' => 'required|string|max:255',
            'classe_id' => 'required|exists:classes,id',
            'photo' => 'nullable|image|max:2048',
        ]);
        // Récupérer l'élève et mettre à jour
        $eleve = Eleve::findOrFail($id);
        $eleve->update($request->all());

        // Redirection après mise à jour
        return redirect()->route('eleves.index')->with('success', 'Élève mis à jour avec succès.');
    }
    // Suppressions eleves 
    public function destroy($id)
    {
        // Récupérer l'élève et le supprimer
        $eleve = Eleve::findOrFail($id);
        $eleve->delete();

        // Redirection après suppression
        return redirect()->route('eleves.index')->with('success', 'Élève supprimé avec succès.');
    }



    public function exportEleves()
    {
        return Excel::download(new ElevesExport, 'eleves.xlsx');
    }
    public function export()
    {
        return Excel::download(new AllDataExport, 'historique_complet.xlsx');
    }
    
}
