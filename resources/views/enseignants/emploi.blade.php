@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Mon emploi du temps</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Heure Début</th>
                <th>Heure Fin</th>
                <th>Classe</th>
                <th>Matière</th>
                <th>Salle</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emplois as $emploi)
            <tr>
                <td>{{ $emploi->date }}</td>
                <td>{{ $emploi->heure_debut }}</td>
                <td>{{ $emploi->heure_fin }}</td>
                <td>{{ $emploi->classe->nom ?? '-' }}</td>
                <td>{{ $emploi->cours->matiere->nom ?? '-' }}</td>
                <td>{{ $emploi->salle->nom ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
