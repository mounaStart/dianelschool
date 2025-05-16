@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Boutons d'exportation -->
    <div class="mb-4">
        <a href="{{ route('eleves.export') }}" class="btn btn-success mr-2">Exporter en Excel</a>
        <a href="{{ route('export.historique') }}" class="btn btn-success">Exporter historique en Excel</a>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row">
        <!-- Élèves -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3 position-relative" style="height: 120px;">
                <div class="position-absolute" style="top: -20px; left: -10px;">
                    <div class="d-flex align-items-center justify-content-center bg-success text-white rounded" style="width: 60px; height: 60px;">
                        <i class="fas fa-users" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <div class="card-body text-right mt-3">
                    <h5 class="card-title">Élèves</h5>
                    <p class="card-text" style="font-size: 1.5rem;">{{ $totalEleves }}</p>
                </div>
            </div>
        </div>

        <!-- Garçons -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3 position-relative" style="height: 120px;">
                <div class="position-absolute" style="top: -20px; left: -10px;">
                    <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded" style="width: 60px; height: 60px;">
                        <i class="fas fa-male" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <div class="card-body text-right mt-3">
                    <h5 class="card-title">Garçons</h5>
                    <p class="card-text" style="font-size: 1.5rem;">{{ $nombreGarcons }}</p>
                </div>
            </div>
        </div>

        <!-- Filles -->
        <div class="col-md-3">
            <div class="card text-white mb-3 position-relative" style="background-color: #e83e8c; height: 120px;">
                <div class="position-absolute" style="top: -20px; left: -10px;">
                    <div class="d-flex align-items-center justify-content-center text-white rounded" style="width: 60px; height: 60px; background-color: #e83e8c;">
                        <i class="fas fa-female" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <div class="card-body text-right mt-3">
                    <h5 class="card-title">Filles</h5>
                    <p class="card-text" style="font-size: 1.5rem;">{{ $nombreFilles }}</p>
                </div>
            </div>
        </div>

        <!-- Classes -->
        <div class="col-md-3">
            <div class="card text-white mb-3 position-relative" style="background-color: #fd7e14; height: 120px;">
                <div class="position-absolute" style="top: -20px; left: -10px;">
                    <div class="d-flex align-items-center justify-content-center text-white rounded" style="width: 60px; height: 60px; background-color: #fd7e14;">
                        <i class="fas fa-school" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <div class="card-body text-right mt-3">
                    <h5 class="card-title">Classes</h5>
                    <p class="card-text" style="font-size: 1.5rem;">{{ $totalClasses }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des 10 derniers élèves -->
    <div class="mt-5">
        <h4>Derniers Élèves Inscrits</h4>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Nom</th>
                        <th>Nationalité</th>
                        <th>Date de nais.</th>
                        <th>Genre</th>
                        <th>Date d'inscription</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dernieresEleves as $eleve)
                        <tr>
                            <td>{{ $eleve->nom }}</td>
                            <td>{{ $eleve->nationalite }}</td>
                            <td>{{ $eleve->date_naissance }}</td>
                            <td>{{ $eleve->sexe }}</td>
                            <td>{{ $eleve->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('eleves.show', $eleve->id) }}" title="Détails">
                                    <i class="fas fa-info-circle text-primary"></i>
                                </a>
                                <a href="{{ route('eleves.suspend', $eleve->id) }}" title="Suspendre" class="ml-3">
                                    <i class="fas fa-ban text-danger"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
