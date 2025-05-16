@extends('layouts.app')

 

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des emplois du temps</h1>
        <a href="{{ route('emplois-du-temps.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un emploi du temps
        </a>
    </div>

    @if($emploisDuTemps->isEmpty())
        <p>Aucun emploi du temps n'a été créé pour le moment.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Classe</th>
                    <th>Date</th>
                    <th>Heure de début</th>
                    <th>Heure de fin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($emploisDuTemps as $emploi)
                <tr>
                    <td>{{ $emploi->classe->nom }}</td>
                    <td>{{ $emploi->date }}</td>
                    <td>{{ $emploi->heure_debut }}</td>
                    <td>{{ $emploi->heure_fin }}</td>
                    <td>
                        <a href="{{ route('emplois-du-temps.edit', $emploi->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <form action="{{ route('emplois-du-temps.destroy', $emploi->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                        <!-- <a href="{{ route('classes.emplois-du-temps.print', $emploi->classe->id) }}" class="btn btn-primary">Imprimer Emploi du Temps</a> -->
                        <a href="{{ route('emplois-du-temps.print', $emploi->id) }}" class="btn btn-primary">Imprimer</a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
 

@endsection