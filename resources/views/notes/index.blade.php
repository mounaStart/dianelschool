@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gestion des Notes</h2>

    <!-- Sélection de la classe -->
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <label for="classe_id">Choisir une classe :</label>
            <select id="classe_id" class="form-control">
                <option value="">-- Sélectionner une classe --</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                @endforeach
            </select>
        </div>

       <!-- Bouton pour ajouter une BULTIN -->
        <button class="btn btn-primary" data-toggle="modal" data-target="#ajoutEvaluationModal">
            Ajouter une Bultin
        </button>
    </div>

    <hr>

    <!-- Tableau des notes -->
    <div id="notesContainer">
        <p>Sélectionnez une classe pour afficher les notes.</p>
    </div>
</div>

<!-- Modal pour ajouter une évaluation
<div class="modal fade" id="ajoutEvaluationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une évaluation</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="ajoutEvaluationForm">
                    @csrf
                    <div class="form-group">
                        <label for="nom">Nom de l'évaluation :</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Date :</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div> -->

@endsection
 


