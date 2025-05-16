@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Entrer les notes pour {{ $evaluation->titre }} ({{ $evaluation->matiere->nom }})</h2>

    <form action="{{ route('notes.store') }}" method="POST">
        @csrf
        <input type="hidden" name="evaluation_id" value="{{ $evaluation->id }}">

        <table class="table">
            <thead>
                <tr>
                    <th>Élève</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                @foreach($eleves as $eleve)
                <tr>
                    <td>{{ $eleve->nom }} {{ $eleve->prenom }}</td>
                    <td>
                    <input type="hidden" name="classe_id"  value="{{  $eleve->classe->id }}" class="form-control" min="0" max="20" step="0.1">
                 
                        <input type="number" name="notes[{{ $eleve->id }}]" class="form-control" min="0" max="20" step="0.1">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-success">Enregistrer les notes</button>
    </form>
</div>
@endsection
