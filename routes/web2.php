<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RoleController;

use App\Http\Controllers\UserController ;
use App\Http\Controllers\EleveController ;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EnseignementController;
use App\Models\Classe;
use App\Models\Eleve ;
use App\Http\Controllers\AnneeScolaireController;
use App\Http\Controllers\MatiereController ;
use App\Http\Controllers\ClasseCoursController ;
use App\Http\Controllers\EmploiDuTempsController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\FraisController ;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\PaiementController ;
use App\Http\Controllers\AbsenceController ;
use App\Http\Controllers\ParentEleveController;
/*
|--------------------------------------------------------------------------
| Web Routesg
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
Route::get('/', function () {
    $totalClasses = Classe::count();
     // Comptage total des élèves
     $totalEleves = Eleve::count();

     // Comptage des garçons (en supposant que le champ `genre` stocke "garçon" ou "fille")
     $nombreGarcons = Eleve::where('sexe', 'Masculin')->count();

     // Comptage des filles
     $nombreFilles = Eleve::where('sexe', 'Féminin')->count();
      // Récupérer les 10 derniers élèves
    // $dernieresEleves = Eleve::orderBy('created_at', 'desc')->take(10)->get();
// Contrôleur
$dernieresEleves = Eleve::where('suspendu', false) // filtre les élèves non suspendus
                   ->latest()
                   ->take(10)
                   ->get();
    return view('welcome', compact('totalClasses','totalEleves','nombreGarcons','nombreFilles','dernieresEleves'));
});
});

Auth::routes();

Route::middleware(['auth', 'role:parents'])->group(function () {
    Route::get('/parents/dashboard', function () {
        return view('parent_portal.dashboard');
    })->name('parents.dashboard');
});
Route::resource('parents', ParentEleveController::class);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::middleware(['role:admin'])->group(function () {
        // Routes accessibles uniquement aux administrateurs
    });

    Route::middleware(['role:teacher'])->group(function () {
        // Routes accessibles uniquement aux enseignants
    });

    

Route::resource('roles', RoleController::class);
Route::post('users/{user}/assign-role', [RoleController::class, 'assign'])->name('users.assign-role');

Route::resource('users', UserController::class);

// Route gestion des eleves 


Route::get('/eleves/export', [EleveController::class, 'exportEleves'])->name('eleves.export');
Route::get('/export/historique', [EleveController::class, 'export'])->name('export.historique');

Route::resource('eleves', EleveController::class);
// Route pour afficher le formulaire d'édition d'un élève
Route::get('/eleves/{id}/edit', [EleveController::class, 'edit'])->name('eleves.edit');

// Route pour mettre à jour les informations d'un élève
Route::put('/eleves/{id}', [EleveController::class, 'update'])->name('eleves.update');

// Route pour supprimer un élève
Route::delete('/eleves/{id}', [EleveController::class, 'destroy'])->name('eleves.destroy');

// Route pour suspendre un élève
Route::post('/eleves/{id}/suspend', [EleveController::class, 'suspend'])->name('eleves.suspend');

// Gestion des classe 

Route::resource('classes', ClasseController::class);

Route::get('/classes', [ClasseCoursController::class, 'index'])->name('classes.index');
Route::get('/classes/{id}/cours', [ClasseCoursController::class, 'manageCours'])->name('classes.cours.manage');
Route::put('/classes/{id}/cours', [ClasseCoursController::class, 'updateCours'])->name('classes.cours.update');

// Gestion des Enseignant 
Route::resource('enseignements', EnseignementController::class);

// Gestion des parents

// Les années scolaire 
Route::middleware(['auth'])->group(function () {
Route::get('/annees-scolaires', [AnneeScolaireController::class, 'index'])->name('annees_scolaires.index');
Route::post('/annees-scolaires', [AnneeScolaireController::class, 'create'])->name('annees_scolaires.create');
});

// Gestion des matiers 
Route::resource('matiers', MatiereController::class);

// Emploie du temps 
Route::resource('emplois-du-temps', EmploiDuTempsController::class);
Route::get('emplois-du-temps/{id}/print', [EmploiDuTempsController::class, 'print'])->name('emplois-du-temps.print');
Route::get('classes/{id}/emplois-du-temps/print', [EmploiDuTempsController::class, 'printClassSchedule'])->name('classes.emplois-du-temps.print');
Route::get('/classes/{id}/imprimer-emplois-du-temps', [ClasseController::class, 'imprimerEmploisDuTemps'])->name('classes.imprimerEmploisDuTemps');
Route::get('/classes/{id}/emploi-du-temps', [ClasseController::class, 'emploiDuTemps'])->name('classes.emploi_du_temps');


//Evaluation
Route::resource('evaluations', EvaluationController::class);
  
Route::get('/notes/create/{evaluation}', [NoteController::class, 'create'])->name('notes.create');

Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
// Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');


Route::get('/notes/get', [NoteController::class, 'getNotes'])->name('notes.get');
Route::post('/evaluations/store', [EvaluationController::class, 'store'])->name('evaluations.store');
Route::get('/matieres/{classe_id}', [App\Http\Controllers\EvaluationController::class, 'getMatieres'])->name('matieres.parClasse');

Route::get('/bulletin/{id}/pdf', [NoteController::class, 'genererBulletinPDF'])->name('bulletin.pdf');
Route::get('/bulletins/tous', [NoteController::class, 'genererTousLesBulletinsPDF'])->name('bulletins.tous.pdf');


//Gestion scolarite frais scolaire 
Route::resource('frais', FraisController::class);
Route::resource('paiements', PaiementController::class);
Route::get('/get-eleves-par-classe', [FactureController::class, 'getElevesParClasse'])->name('get.eleves.par.classe');
Route::get('/factures/{id}/recu', [FactureController::class, 'generateReceipt'])->name('factures.recu');
Route::get('/factures/en-retard', [FactureController::class, 'facturesEnRetard'])->name('factures.en_retard');
Route::resource('factures', FactureController::class);
Route::resource('factures', FactureController::class)->except(['show']);

Route::get('/factures/{id}/paiement', [FactureController::class, 'afficherFormulairePaiement'])->name('factures.paiement.form');
Route::post('/factures/{id}/paiement', [FactureController::class, 'enregistrerPaiement'])->name('factures.paiement');

// gestion suivie
Route::get('/classe/{id}/eleves', [AbsenceController::class, 'getElevesByClasse']);
Route::post('/absences/multiple', [AbsenceController::class, 'storeMultiple'])->name('absences.storeMultiple');

Route::resource('absences', App\Http\Controllers\AbsenceController::class)->only([
    'index', 'create', 'store'
]);

 
Route::middleware(['auth', 'role:eleve'])->group(function () {
    Route::get('/dashboard/eleve', [EleveController::class, 'index'])->name('eleve.dashboard');
});


});
