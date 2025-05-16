 

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Ajouter une facture</h1>

    <form action="{{ route('factures.store') }}" method="POST">
    @csrf
    <div class="form-group">
            <label for="classe_id">Classe</label>
            <select id="classe_id" name="classe_id" class="form-control" required>
                <option value="" disabled selected>-- Sélectionner une classe --</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="eleve_id">Élève</label>
            <select id="eleve_id" name="eleve_id" class="form-control" required>
                <option value="" disabled selected>-- Sélectionner un élève --</option>
                <!-- Les élèves seront chargés ici dynamiquement -->
            </select>
        </div>
    

    <div class="form-group">
        <label for="frais_id">Frais Scolaires</label>
        <select name="frais_id[]" id="frais_id" class="form-control" multiple required>
            <!-- Options des frais scolaires -->
            @foreach($fraisScolaires as $frais)
                <option value="{{ $frais->id }}">{{ $frais->nom }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="montant_total">Montant Total</label>
        <input type="number" name="montant_total" id="montant_total" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="date_emission">Date d'émission</label>
        <input type="date" name="date_emission" id="date_emission" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Ajouter la facture</button>
</form>

</div>
@endsection

