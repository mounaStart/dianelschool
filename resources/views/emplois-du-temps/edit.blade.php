@extends('layouts.app')

@section('content')
<form action="{{ route('emplois-du-temps.update', $emploiDuTemps->id) }}" method="POST">
    @csrf 
    @method('PUT') <!-- Méthode HTTP PUT pour la mise à jour -->

    <div class="form-group">
        <label>Date</label>
        <input type="date" name="date" class="form-control" value="{{ $emploiDuTemps->date }}" required>
    </div>
    <div class="form-group">
        <label>Heure Début</label>
        <input type="time" name="heure_debut" class="form-control" value="{{ $emploiDuTemps->heure_debut }}" required>
    </div>
    <div class="form-group">
        <label>Heure Fin</label>
        <input type="time" name="heure_fin" class="form-control" value="{{ $emploiDuTemps->heure_fin }}" required>
        @error('heure_fin')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label>Classe</label>
        <select name="classe_id" class="form-control" required>
            @foreach($classes as $classe)
                <option value="{{ $classe->id }}" {{ $classe->id == $emploiDuTemps->classe_id ? 'selected' : '' }}>
                    {{ $classe->nom }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Cours</label>
        <select name="cours_id" class="form-control" required>
            @foreach($cours as $cour)
                <option value="{{ $cour->id }}" {{ $cour->id == $emploiDuTemps->cours_id ? 'selected' : '' }}>
                    {{ $cour->matiere->nom }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Salle</label>
        <select name="salle_id" class="form-control" required>
            @foreach($salles as $salle)
                <option value="{{ $salle->id }}" {{ $salle->id == $emploiDuTemps->salle_id ? 'selected' : '' }}>
                    {{ $salle->nom }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Enseignant</label>
        <select name="enseignant_id" class="form-control" required>
            @foreach($cours as $cour)
                <option value="{{ $cour->enseignement->id }}" {{ $cour->enseignement->id == $emploiDuTemps->enseignant_id ? 'selected' : '' }}>
                    {{ $cour->enseignement->nom }} {{ $cour->enseignement->prenom }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Mettre à jour</button>
</form>
@endsection
