@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Liste des Matières</h2>
        <a href="{{ route('matiers.create') }}" class="btn btn-primary">Ajouter une matière</a>

        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom de la Matière</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matiers as $matier)
                    <tr>
                        <td>{{ $matier->id }}</td>
                        <td>{{ $matier->nom }}</td>
                        <td>
                            <a href="{{ route('matiers.edit', $matier->id) }}" class="btn btn-warning">Modifier</a>
                            <form action="{{ route('matiers.destroy', $matier->id) }}" method="POST" style="display:inline;">
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
