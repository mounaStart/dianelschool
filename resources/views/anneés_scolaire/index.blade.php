@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Années Scolaires</h1>

    <!-- Bouton pour ouvrir le modal d'ajout -->
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#ajouterAnneeModal">
        Ajouter une année scolaire
    </button>

    <!-- Tableau des années scolaires -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Année Scolaire</th>
                <th>Date de Début</th>
                <th>Date de Fin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($anneesScolaires as $annee)
                <tr>
                    <td>{{ $annee->annee_scolaire }}</td>
                    <td>{{ \Carbon\Carbon::parse($annee->date_debut)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($annee->date_fin)->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal d'ajout d'année scolaire -->
<div class="modal fade" id="ajouterAnneeModal" tabindex="-1" aria-labelledby="ajouterAnneeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('annees_scolaires.create') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="ajouterAnneeModalLabel">Ajouter une année scolaire</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="annee_scolaire">Année scolaire (ex: 2023-2024)</label>
                        <input type="text" name="annee_scolaire" id="annee_scolaire" class="form-control" required pattern="^\d{4}-\d{4}$" placeholder="2023-2024">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
