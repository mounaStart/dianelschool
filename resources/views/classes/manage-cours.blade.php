@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Organisation des cours pour {{ $classe->nom }}</h1>
    <form method="POST" action="{{ route('classes.cours.update', $classe->id) }}">
        @csrf
        @method('PUT')
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Matière</th>
                    <th>Enseignant</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matieres as $matiere)
                <tr>
                    <td>{{ $matiere->nom }}</td>
                    <td>
                        <select name="cours[{{ $matiere->id }}]" class="form-select">
                            <option value="">-- Sélectionner un enseignant --</option>
                            @foreach($enseignants as $enseignant)
                            <option value="{{ $enseignant->id }}" {{ optional($cours->where('matiere_id', $matiere->id)->first())->enseignement_id == $enseignant->id ? 'selected' : '' }}>
                                {{ $enseignant->nom }} {{ $enseignant->prenom }}
                            </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>
@endsection
