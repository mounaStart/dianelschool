@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Modifier le frais scolaire</h1>

    <form action="{{ route('frais.update', $frais->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nom">Nom du frais</label>
            <input type="text" id="nom" name="nom" value="{{ $frais->nom }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="montant">Montant (MRO)</label>
            <input type="number" step="0.01" id="montant" name="montant" value="{{ $frais->montant }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description (optionnelle)</label>
            <textarea id="description" name="description" class="form-control">{{ $frais->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Enregistrer les modifications
        </button>
        <a href="{{ route('frais.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </form>
</div>
@endsection
