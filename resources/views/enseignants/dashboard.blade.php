@extends('layouts.app')

@section('content')
<div class="container">
     <h2 class="mb-4">Tableau de bord des parents</h2>

    <div class="row">

        <!-- Infos enseignant -->
        <div class="col-md-4">
            <div class="card border-primary mb-3">
                <div class="card-header bg-primary text-white">
                    Informations de l'enseignant
                </div>
                <div class="card-body">
                    <p><strong>Nom :</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email :</strong> {{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- Classes -->
        <div class="col-md-4">
            <div class="card border-success mb-3">
                <div class="card-header bg-success text-white">
                    Mes Classes
                </div>
                <div class="card-body">
                    @if($classes->count())
                        <ul class="list-group">
                            @foreach($classes as $classe)
                                <li class="list-group-item">{{ $classe->nom }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>Aucune classe assignée</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
                <!-- Matières -->
            <div class="card border-info mb-3">
                <div class="card-header bg-info  text-white">
                    Matières enseignées
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse($matieres as $matiere)
                            <li class="list-group-item">{{ $matiere->nom }}</li>
                        @empty
                            <li class="list-group-item">Aucune matière trouvée</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <!-- Accès emploi du temps -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    Accès rapide
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('enseignants.emploi') }}" class="btn btn-info">
                        <i class="fas fa-calendar-alt"></i> Voir mon emploi du temps
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
