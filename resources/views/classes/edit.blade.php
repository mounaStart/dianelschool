@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifier la classe</h1>

        <form action="{{ route('classes.update', $classe->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nom">Nom de la classe</label>
                <input type="text" name="nom" class="form-control" value="{{ $classe->nom }}" required>
            </div>
            <div class="form-group">
                <label for="niveau">Niveau</label>
                <input type="text" name="niveau" class="form-control" value="{{ $classe->niveau }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
@endsection
