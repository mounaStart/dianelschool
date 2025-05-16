@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Feuille d’appel - Enregistrement des absences</h2>

    <form action="{{ route('absences.storeMultiple') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="classe_id" class="form-label">Classe</label>
            <select name="classe_id" id="classe_id" class="form-control" required>
                <option value="">-- Sélectionner une classe --</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                @endforeach
            </select>
        </div>

        <div id="eleves-list" style="display:none;">
            <h4>Liste des élèves</h4>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Absent</th>
                    </tr>
                </thead>
                <tbody id="eleves-table-body">
                    <!-- Élèves dynamiques ici -->
                </tbody>
            </table>

            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>

            </div>

            <button type="submit" class="btn btn-primary">Enregistrer la feuille d’appel</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#classe_id').change(function () {
        let classeId = $(this).val();

        if (classeId) {
            $.ajax({
                url: '/classe/' + classeId + '/eleves',
                method: 'GET',
                success: function (eleves) {
                    let rows = '';
                    eleves.forEach((eleve, index) => {
                        rows += `
                            <tr>
                                <td>${eleve.nom}</td>
                                <td>${eleve.prenom}</td>
                                <td>
                                    <input type="checkbox" name="absents[]" value="${eleve.id}">
                                </td>
                            </tr>`;

                    });
                    $('#eleves-table-body').html(rows);
                    $('#eleves-list').show();
                }
            });
        } else {
            $('#eleves-list').hide();
        }
    });
</script>
@endsection
