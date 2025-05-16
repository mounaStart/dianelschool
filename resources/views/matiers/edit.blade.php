@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Modifier la Matière</h2>

        <form action="{{ route('matiers.update', $matier->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nom de la Matière</label>
                <input type="text" name="name" class="form-control" value="{{ $matier->nom }}" required>
            </div>

            <button type="submit" class="btn btn-warning mt-3">Mettre à jour</button>
        </form>
    </div>
@endsection
