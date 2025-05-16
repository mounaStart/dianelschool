@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Détails de l'élève: {{ $eleve->prenom }} {{ $eleve->nom }}</h2>

        <div class="row">
            <div class="col-md-6">
                <ul class="list-group">
                    <li class="list-group-item"><strong>Nom:</strong> {{ $eleve->nom }}</li>
                    <li class="list-group-item"><strong>Prénom:</strong> {{ $eleve->prenom }}</li>
                    <li class="list-group-item"><strong>Classe:</strong> {{ $eleve->classe->nom }}</li>
                    <li class="list-group-item"><strong>Numéro National:</strong> {{ $eleve->numero_national }}</li>
                    <li class="list-group-item"><strong>Date de Naissance:</strong> {{ $eleve->date_naissance }}</li>
                    <li class="list-group-item"><strong>Lieu de Naissance:</strong> {{ $eleve->lieux_naissance }}</li>
                    <li class="list-group-item"><strong>Adresse:</strong> {{ $eleve->adresse }}</li>
                    <li class="list-group-item"><strong>Téléphone 1:</strong> {{ $eleve->telephone1 }}</li>
                    <li class="list-group-item"><strong>Téléphone 2:</strong> {{ $eleve->telephone2 }}</li>
                    <li class="list-group-item"><strong>Sexe:</strong> {{ $eleve->sexe }}</li>
                    <li class="list-group-item"><strong>Nationalité:</strong> {{ $eleve->nationalite }}</li>
                </ul>
            </div>

            <div class="col-md-6">
                <h3>Photo de l'élève</h3>
                <img src="{{ asset('storage/' . $eleve->photo) }}" alt="Photo de {{ $eleve->nom }}" class="img-fluid">
            </div>
        </div>

        <a href="{{ route('eleves.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
    </div>
@endsection
