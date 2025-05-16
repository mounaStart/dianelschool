@extends('layouts.app')

@section('content')
<div class="container mt-5">
       
        <h1>Liste des Enseignenets </h1>

        <a href="{{ route('enseignements.create') }}" class="btn btn-primary mb-3">Ajouter un enseignenet</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Sexe</th>
                    <th>Email</th>
                    <th>Tel</th>
                    <th>Diplome</th>
                    <th>Type contrat</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($Enseignements as $Enseignement)
                    <tr>
                        <td>{{ $Enseignement->nom }}</td>
                        <td>{{ $Enseignement->prenom }}</td>
                        <td>{{ $Enseignement->sexe }}</td>
                        <td>{{ $Enseignement->email }}</td>
                        <td>{{ $Enseignement->telephone }}</td>
                        <td>{{ $Enseignement->diplome }}</td>
                        <td>{{ $Enseignement->type_contrat }}</td>

                        <td>
                            <a href="{{ route('enseignements.edit', $Enseignement->id) }}" class="btn btn-warning">Modifier</a>
                            <form action="{{ route('enseignements.destroy', $Enseignement->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
