@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Liste des factures</h1>

    <div class="d-flex justify-content-between mb-3">
        <div>
            <a href="{{ route('factures.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajouter une facture
            </a>

            <a href="{{ route('factures.en_retard') }}" class="btn btn-danger">
                <i class="fas fa-exclamation-triangle"></i> Factures en retard
            </a>
             

        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Élève</th>
                <th>Frais</th>
                <th>Montant Total (MRO)</th>
                <th>Date d'émission</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($factures as $facture)
                <tr>
                    <td>{{ $facture->eleve->nom ?? 'N/A' }}</td>
                    <td>
                        @foreach($facture->frais as $frais)
                            {{ $frais->nom }}<br>
                        @endforeach
                    </td>
                    <td>{{ number_format($facture->montant_total, 2) }}</td>
                    <td>{{ $facture->date_emission }}</td>
                    <td>
                        <a href="{{ route('factures.edit', $facture->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="{{ route('factures.recu', $facture->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-file-pdf"></i> Générer le reçu
                        </a>
                        <a href="{{ route('factures.paiement.form', $facture->id) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-dollar-sign"></i> Payments
                        </a>
                        
                        <form action="{{ route('factures.destroy', $facture->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Voulez-vous vraiment supprimer cette facture ?')">
                                <i class="fas fa-trash-alt"></i> Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
