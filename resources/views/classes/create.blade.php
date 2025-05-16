@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ajouter une classe</h1>

        <form action="{{ route('classes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nom">Nom de la classe</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="niveau">Niveau</label>
                <input type="text" name="niveau" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
@endsection
