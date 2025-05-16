@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajouter une évaluation</h2>
    
    <form action="{{ route('evaluations.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="classe_id" class="form-label">Classe</label>
            <select name="classe_id" class="form-control" id="classe_id" required>
                <option value="">-- Sélectionnez une classe --</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="matiere_id" class="form-label">Matière</label>
            <select name="matiere_id" class="form-control" id="matiere_id" required>
                <option value="">-- Sélectionnez une matière --</option>
            </select>
        </div>

        <!-- <div class="mb-3">
            <label for="classe_id" class="form-label">Classe</label>
            <select name="classe_id" class="form-control" required>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="matiere_id" class="form-label">Matière</label>
            <select name="matiere_id" class="form-control" required>
                @foreach($cours as $matiere)
                @if($matiere->classe_id)
                    <option value="{{ $matiere->id }}">{{ $matiere->matiere->nom }}</option>
                @endif
                    @endforeach
            </select>
        </div> -->

        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>
@endsection
