@extends('layouts.app')

@section('content')
<h4>Informations du parent</h4>
<p><strong>Nom : </strong> {{ $parent->nom }}</p>
<p><strong>Prénom : </strong> {{ $parent->prenom }}</p>
<p><strong>Téléphone : </strong> {{ $parent->telephone }}</p>

<hr>

<h4>Enfants associés</h4>
@if($eleves->isEmpty())
    <p>Aucun élève associé à ce parent.</p>
@else
    <ul class="list-group">
        @foreach($eleves as $eleve)
            <li class="list-group-item">
                {{ $eleve->nom }} {{ $eleve->prenom }} — Classe : {{ $eleve->classe->nom ?? 'Non assignée' }}
            </li>
        @endforeach
    </ul>
@endif
@endsection