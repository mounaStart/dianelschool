<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    RoleController,
    UserController,
    EleveController,
    ClasseController,
    EnseignementController,
    AnneeScolaireController,
    MatiereController,
    ClasseCoursController,
    EmploiDuTempsController,
    EvaluationController,
    NoteController,
    FraisController,
    FactureController,
    PaiementController,
    AbsenceController,
    ParentEleveController,
    ProfilController,
    EnseignantController
};
use App\Models\{Classe, Eleve};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        $user = Auth::user();

        // Si l'utilisateur est un enseignant, rediriger vers leur dashboard
        if ($user->hasRole('enseignant')) {
            return redirect('/enseignants/dashboard');
        }
        if ($user->hasRole('parents')) {
            return redirect('/parents/dashboard');
        }
      
        
        // Seul l'admin peut accéder à la page welcome
        if ($user->hasRole('admin') ) {
            $totalClasses = Classe::count();
            $totalEleves = Eleve::count();
            $nombreGarcons = Eleve::where('sexe', 'Masculin')->count();
            $nombreFilles = Eleve::where('sexe', 'Féminin')->count();
            $dernieresEleves = Eleve::where('suspendu', 1)->latest()->take(10)->get();

            return view('welcome', compact('totalClasses', 'totalEleves', 'nombreGarcons', 'nombreFilles', 'dernieresEleves'));
        }

        // Sinon, rediriger vers login ou erreur 403
        abort(403, 'Accès refusé.');
    });
});
Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/mon-profil', [ProfilController::class, 'show'])->name('profil.show');
    
});
 
// Dashboard parent
Route::middleware(['auth', 'role:parents'])->group(function () {
   
    Route::get('/parents/dashboard', [ParentEleveController::class, 'dashboard'])->name('parents.dashboard');

    // web.php
Route::get('/parents/notes', [ParentEleveController::class, 'notes'])->name('parents.notes');

    Route::resource('parents', ParentEleveController::class);

});

// Dashboard enseignements
Route::middleware(['auth', 'role:enseignant'])->group(function () {
    
    Route::get('/enseignants/dashboard', [EnseignementController::class, 'dashboard'])->name('enseignants.dashboard');

    Route::get('/enseignants/enseignements', [EnseignementController::class, 'mesClasses'])->name('enseignants.enseignements');

    Route::get('/enseignants/matieres', [EnseignementController::class, 'matieres'])->name('enseignants.matieres');
    Route::get('/enseignants/emploi-du-temps', [EnseignementController::class, 'emploiDuTemps'])->name('enseignants.emploi');

    Route::resource('enseignants', EnseignementController::class);
});

 Route::middleware(['auth', 'checkrole:admin'])->group(function () {

    // Route::get('/parents', [ParentEleveController::class, 'dashboard'])->name('parents.dashboard');

     Route::resource('parents', ParentEleveController::class);

});
// Dashboard élève
Route::middleware(['auth', 'role:eleve'])->group(function () {
    Route::get('/dashboard/eleve', [EleveController::class, 'index'])->name('eleve.dashboard');
});

// Accès général après login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Admin seulement
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('roles', RoleController::class);
        Route::post('users/{user}/assign-role', [RoleController::class, 'assign'])->name('users.assign-role');
        Route::resource('users', UserController::class);
    });

    // Routes gestion des élèves
    Route::get('/eleves/export', [EleveController::class, 'exportEleves'])->name('eleves.export');
    Route::get('/export/historique', [EleveController::class, 'export'])->name('export.historique');
    Route::resource('eleves', EleveController::class);
    Route::post('/eleves/{id}/suspend', [EleveController::class, 'suspend'])->name('eleves.suspend');

    // Gestion des classes et cours
    Route::resource('classes', ClasseController::class);
    Route::get('/classes/{id}/cours', [ClasseCoursController::class, 'manageCours'])->name('classes.cours.manage');
    Route::put('/classes/{id}/cours', [ClasseCoursController::class, 'updateCours'])->name('classes.cours.update');

    // Enseignants
    Route::resource('enseignements', EnseignementController::class);

    // Années scolaires
    Route::get('/annees-scolaires', [AnneeScolaireController::class, 'index'])->name('annees_scolaires.index');
    Route::post('/annees-scolaires', [AnneeScolaireController::class, 'create'])->name('annees_scolaires.create');

    // Matières
    Route::resource('matiers', MatiereController::class);

    // Emplois du temps
    Route::resource('emplois-du-temps', EmploiDuTempsController::class);
    Route::get('emplois-du-temps/{id}/print', [EmploiDuTempsController::class, 'print'])->name('emplois-du-temps.print');
    Route::get('classes/{id}/emplois-du-temps/print', [EmploiDuTempsController::class, 'printClassSchedule'])->name('classes.emplois-du-temps.print');
    Route::get('/classes/{id}/imprimer-emplois-du-temps', [ClasseController::class, 'imprimerEmploisDuTemps'])->name('classes.imprimerEmploisDuTemps');
    Route::get('/classes/{id}/emploi-du-temps', [ClasseController::class, 'emploiDuTemps'])->name('classes.emploi_du_temps');

    // Évaluations et notes
    Route::resource('evaluations', EvaluationController::class);
    //Route::post('/evaluations/store', [EvaluationController::class, 'store'])->name('evaluations.store');
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::get('/notes/create/{evaluation}', [NoteController::class, 'create'])->name('notes.create');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/notes/get', [NoteController::class, 'getNotes'])->name('notes.get');
    Route::get('/matieres/{classe_id}', [EvaluationController::class, 'getMatieres'])->name('matieres.parClasse');
    Route::get('/bulletin/{id}/pdf', [NoteController::class, 'genererBulletinPDF'])->name('bulletin.pdf');
    Route::get('/bulletins/tous', [NoteController::class, 'genererTousLesBulletinsPDF'])->name('bulletins.tous.pdf');

    // Gestion des frais scolaires
    Route::resource('frais', FraisController::class);
    Route::resource('paiements', PaiementController::class);
    Route::get('/get-eleves-par-classe', [FactureController::class, 'getElevesParClasse'])->name('get.eleves.par.classe');
    Route::get('/factures/{id}/recu', [FactureController::class, 'generateReceipt'])->name('factures.recu');
    Route::get('/factures/en-retard', [FactureController::class, 'facturesEnRetard'])->name('factures.en_retard');
    Route::resource('factures', FactureController::class)->except(['show']);
    Route::get('/factures/{id}/paiement', [FactureController::class, 'afficherFormulairePaiement'])->name('factures.paiement.form');
    Route::post('/factures/{id}/paiement', [FactureController::class, 'enregistrerPaiement'])->name('factures.paiement');

    // Gestion des absences
    Route::get('/classe/{id}/eleves', [AbsenceController::class, 'getElevesByClasse']);
    Route::post('/absences/multiple', [AbsenceController::class, 'storeMultiple'])->name('absences.storeMultiple');
    Route::resource('absences', AbsenceController::class)->only(['index', 'create', 'store']);
});
