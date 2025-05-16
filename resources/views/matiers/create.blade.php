@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Ajouter une Matière</h2>

        <form action="{{ route('matiers.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nom de la Matière</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="coefficient">Ccoefficient</label>
                <input type="number" name="coefficient" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success mt-3">Ajouter</button>
        </form>
    </div>
@endsection
