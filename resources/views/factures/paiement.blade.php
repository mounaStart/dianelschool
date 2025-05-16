@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Enregistrer un paiement</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Élève :</strong> {{ $facture->eleve->nom ?? 'N/A' }}</p>
            <p><strong>Montant total :</strong> {{ number_format($facture->montant_total, 2) }} MRO</p>
            <p><strong>Date d'échéance :</strong> {{ $facture->date_echeance }}</p>
        </div>
    </div>

    <form action="{{ route('factures.paiement', $facture->id) }}" method="POST" class="mt-3">
        @csrf
         
        <div class="form-group">
            <label for="montant_paye">Montant payé</label>
            <input type="number" name="montant_paye" class="form-control" required max="{{ $facture->montant_total }}">
        </div>

        <!-- <div class="form-group">
            <label for="mode_paiement">Mode de paiement</label>
            <input type="text" name="mode_paiement" class="form-control" required>
        </div> -->
        <div class="form-group">
        <label for="mode_paiement">Mode de paiement</label>
        <select name="mode_paiement" class="form-control" required>
            <option value="Espèces">Espèces</option>
            <option value="Virement bancaire">Virement bancaire</option>
            <option value="Chèque">Chèque</option>
            <option value="Mobile Money">Mobile Money</option>
        </select>
    </div>

        <div class="form-group">
            <label for="date_paiement">Date de paiement</label>
            <input type="date" name="date_paiement" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-check"></i> Valider le paiement
        </button>
    </form>
</div>
@endsection
