@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Factures en retard</h1>

    @if($factures->isEmpty())
        <div class="alert alert-info">Aucune facture en retard pour le moment.</div>
    @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Élève</th>
                    <th>Montant Total (MRO)</th>
                    <th>Date d'échéance</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($factures as $facture)
                    <tr>
                        <td>{{ $facture->eleve->nom ?? 'N/A' }}</td>
                        <td>{{ number_format($facture->montant_total, 2) }}</td>
                        <td>{{ $facture->date_echeance }}</td>
                        <td><span class="badge badge-danger">En retard</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
