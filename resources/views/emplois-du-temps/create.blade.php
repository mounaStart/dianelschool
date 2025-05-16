 
@extends('layouts.app')

@section('content')
<form action="{{ route('emplois-du-temps.store') }}" method="POST">
    @csrf 
    <div class="form-group">
        <label>Date</label>
        <input type="date" name="date" class="form-control" value="{{ old('date') }}" required>
        @error('date')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label>Heure Début</label>
        <input type="time" name="heure_debut" class="form-control" value="{{ old('heure_debut') }}" required>
        @error('heure_debut')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label>Heure Fin</label>
        <input type="time" name="heure_fin" class="form-control" value="{{ old('heure_fin') }}" required>
        @error('heure_fin')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label>Classe</label>
        <select name="classe_id" class="form-control" required>
            @foreach($classes as $classe)
                <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
            @endforeach
        </select>
        @error('classe_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label>Cours</label>
        <select name="cours_id" class="form-control" required>
            @foreach($cours as $cour)
                <option value="{{ $cour->id }}" {{ old('cours_id') == $cour->id ? 'selected' : '' }}>{{ $cour->matiere->nom }}</option>
            @endforeach
        </select>
        @error('cours_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label>Salle</label>
        <select name="salle_id" class="form-control" required>
            @foreach($salles as $salle)
                <option value="{{ $salle->id }}" {{ old('salle_id') == $salle->id ? 'selected' : '' }}>{{ $salle->nom }}</option>
            @endforeach
        </select>
        @error('salle_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label>Enseignant</label>
        <select name="enseignant_id" class="form-control" required>
            @foreach($cours as $cour)
                <option value="{{ $cour->enseignement->id }}" {{ old('enseignant_id') == $cour->enseignement->id ? 'selected' : '' }}>
                    {{ $cour->enseignement->nom }} {{ $cour->enseignement->prenom }}
                </option>
            @endforeach
        </select>
        @error('enseignant_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>


@endsection
