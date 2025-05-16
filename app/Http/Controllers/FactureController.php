<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\FraisScolaire;
use Illuminate\Http\Request;
use App\Models\Eleve;
use App\Models\Classe ;
use App\Models\Paiement;
use PDF;


class FactureController extends Controller
{
    // 🔹 Afficher la liste des factures
    public function index()
    {
        $factures = Facture::with('frais')
        ->where('statut', 'en attente')
        ->get();
        return view('factures.index', compact('factures'));
    }

    public function create()
    {
        $classes = Classe::all();  // Récupération des classes
        $fraisScolaires = FraisScolaire::all();
        $frais = FraisScolaire::all();
        return view('factures.create', compact('classes', 'frais','fraisScolaires'));
    }
  
    // Méthode pour récupérer les élèves d'une classe via AJAX
    public function getElevesParClasse(Request $request)
    {
        $eleves = Eleve::where('classe_id', $request->classe_id)->get();
        return response()->json($eleves);
    }


    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'eleve_id' => 'required|integer|exists:eleves,id',
            'frais_id' => 'required|array|exists:frais_scolaires,id', // Changement ici pour accepter un tableau de frais
            'montant_total' => 'required|numeric|min:0',
            'date_emission' => 'required|date',
        ]);
    
        // Créer la facture dans la table factures
        $facture = Facture::create([
            'eleve_id' => $request->eleve_id,
            'montant_total' => $request->montant_total,
            'date_emission' => $request->date_emission,
        ]);
    
        // Attacher les frais à la facture via la table pivot
        $facture->frais()->attach($request->frais_id);
    
        // Rediriger avec un message de succès
        return redirect()->route('factures.index')->with('success', 'Facture ajoutée avec succès.');
    }
    

    // 🔹 Afficher le formulaire de modification d'une facture
    public function edit(Facture $facture)
    {
        $frais = FraisScolaire::all();
        return view('factures.edit', compact('facture', 'frais'));
    }

    // 🔹 Mettre à jour une facture
    public function update(Request $request, Facture $facture)
    {
        $request->validate([
            'eleve_id' => 'required|integer|exists:eleves,id',
            'frais_id' => 'required|integer|exists:frais_scolaires,id',
            'montant_total' => 'required|numeric|min:0',
            'date_emission' => 'required|date',
        ]);

        $facture->update($request->all());

        return redirect()->route('factures.index')->with('success', 'Facture mise à jour avec succès.');
    }

    // 🔹 Supprimer une facture
    public function destroy(Facture $facture)
    {
        $facture->delete();

        return redirect()->route('factures.index')->with('success', 'Facture supprimée avec succès.');
    }
   

    public function generateReceipt($id)
    {
        $facture = Facture::with('eleve', 'frais')->findOrFail($id);

        $pdf = PDF::loadView('factures.recu', compact('facture'));

        // Télécharger directement le fichier PDF avec un nom personnalisé
        return $pdf->download('Recu_Facture_'.$facture->id.'.pdf');
    }
    public function facturesEnRetard()
    {
        $factures = Facture::where('date_echeance', '<', now()) // Factures avec date dépassée
                        ->where('statut', 'non payé')
                        ->with('eleve')
                        ->get();

        return view('factures.en_retard', compact('factures'));
    }

    public function show($id)
    {
        $facture = Facture::with('eleve', 'frais')->findOrFail($id);

        return view('factures.show', compact('facture'));
    }
    // Afficher le formulaire de paiement
    public function afficherFormulairePaiement($id)
    {
        $facture = Facture::findOrFail($id);
        return view('factures.paiement', compact('facture'));
    }

    // Enregistrer le paiement
    public function enregistrerPaiement(Request $request, $id)
    { 
        $facture = Facture::findOrFail($id);
       
        $request->validate([
           'montant_paye' => 'required|numeric|min:0|max:' . $facture->montant_total,
            'mode_paiement' => 'required|string',
            'date_paiement' => 'required|date',
        ]);

       

        Paiement::create([
            'facture_id' => $facture->id,
            'montant_paye' => $request->montant_paye,
            'mode_paiement' => $request->mode_paiement,
            'date_paiement' => $request->date_paiement,
        ]);

        // Mise à jour du statut de la facture
        $facture->mettreAJourStatut();

        return redirect()->route('factures.index')->with('success', 'Paiement enregistré avec succès.');
    }

   



}
