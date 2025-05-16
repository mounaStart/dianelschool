@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Liste des évaluations</h2>

    <a href="{{ route('evaluations.create') }}" class="btn btn-success mb-3">Ajouter une évaluation</a>

    <table class="table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Date</th>
                <th>Classe</th>
                <th>Matière</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($evaluations as $evaluation)
            <tr>
                <td>{{ $evaluation->titre }}</td>
                <td>{{ $evaluation->date }}</td>
                <td>{{ $evaluation->classe->nom }}</td>
                <td>{{ $evaluation->matiere_id }}</td>
                <td>
                    <a href="{{ route('notes.create', $evaluation->id) }}" class="btn btn-primary">Entrer les notes</a>
                    <a href="{{ route('evaluations.destroy', $evaluation->id) }}" class="btn btn-danger"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ?')">Supprimer</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
