@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Tableau de bord des parents</h2>

    <div class="row">
        <!-- Carte d'information sur le parent -->
        <div class="col-md-5">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    Informations du parent
                </div>
                <div class="card-body">
                    <p><strong>Nom :</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email :</strong> {{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- Carte nombre d'enfants -->
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    Nombre d'enfants inscrits
                </div>
                <div class="card-body">
                    <h3>{{ $nombreEnfants ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Carte accès bulletins -->
        <div class="col-md-4">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    Actions rapides
                </div>
                <div class="card-body">
                    <a href="{{ route('parents.notes') }}" class="btn btn-info btn-block">
                        Voir les bulletins
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des enfants -->
    <div class="mt-5">
        <h4>Enfants inscrits</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Classe</th>
                    <th>Année scolaire</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($enfants ?? [] as $enfant)
                    <tr>
                        <td>{{ $enfant->nom }}</td>
                        <td>{{ $enfant->prenom }}</td>
                        <td>{{ $enfant->classe->nom ?? 'Non assigné' }}</td>
                        <td>{{ $enfant->annee_scolaire_id ?? 'Non défini' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Aucun enfant inscrit.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
