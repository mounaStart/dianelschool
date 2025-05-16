@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Liste des parents</h3>
    <a href="{{ route('parents.create') }}" class="btn btn-primary mb-3">Ajouter un parent</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($parents as $parent)
            <tr>
                <td>{{ $parent->nom }}</td>
                <td>{{ $parent->prenom }}</td>
                <td>{{ $parent->telephone }}</td>
                <td>{{ $parent->relation }}</td>
                
                <td>
                <a href="{{ route('parents.show', $parent->id) }}" class="btn btn-info btn-sm">
                        Voir fiche
                    </a>
                    <a href="{{ route('parents.edit', $parent) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('parents.destroy', $parent) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Confirmer la suppression ?')" class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
