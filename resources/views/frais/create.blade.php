@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Ajouter un frais scolaire</h1>

    <form action="{{ route('frais.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nom">Type de frais</label>
            <input type="text" id="nom" name="nom" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="montant">Montant (MRU)</label>
            <input type="number" step="0.01" id="montant" name="montant" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="classe_id">Classe</label>
            <select id="classe_id" name="classe_id" class="form-control" required>
                @foreach ($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description (optionnelle)</label>
            <textarea id="description" name="description" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Enregistrer
        </button>
        <a href="{{ route('frais.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </form>
</div>
@endsection
