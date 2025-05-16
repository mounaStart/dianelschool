@extends('layouts.app')

@section('content')
<div class="container">
<div class="d-flex justify-content-between mb-3">
        <h1>Emploi du Temps de la Classe : {{ $classe->nom }}</h1>
        <button class="btn btn-primary" id="printButton">Imprimer</button>
    </div>
    <div id="emploiDuTemps">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Heures</th>
                @foreach ($jours as $jour)
                    <th>{{ ucfirst($jour) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
                // Définir des plages horaires
                $heures = [
                    '08:00 - 09:00',
                    '09:00 - 10:00',
                    '10:00 - 11:00',
                    '11:00 - 12:00',
                    '14:00 - 15:00',
                    '15:00 - 16:00',
                    '16:00 - 17:00',
                ];
            @endphp

            @foreach ($heures as $plageHoraire)
                <tr>
                    <td>{{ $plageHoraire }}</td>
                    @foreach ($jours as $jour)
                        @php
                            // Vérifier si des emplois du temps existent pour ce jour
                            $emploisJour = $emploiParJour[$jour] ?? collect();

                            $emploi = $emploisJour->firstWhere(function ($emploi) use ($plageHoraire) {
                                $debutFin = explode(' - ', $plageHoraire);
                                return $emploi->heure_debut <= $debutFin[0] && $emploi->heure_fin > $debutFin[1];
                            });
                        @endphp

                        <td>
                            @if ($emploi)
                                <strong>{{ $emploi->cours->matiere->nom }}</strong><br>
                                Salle : {{ $emploi->salle->nom }}<br>
                                <small>{{ $emploi->cours->enseignement->nom }} {{ $emploi->cours->enseignement->prenom }}</small>
                            @else
                                -
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>

<script>
    document.getElementById('printButton').addEventListener('click', function () {
        // Copier le contenu à imprimer
        const contenu = document.getElementById('emploiDuTemps').innerHTML;

        // Ouvrir une nouvelle fenêtre pour l'impression
        const fenetreImpression = window.open('', '_blank');
        fenetreImpression.document.open();
        fenetreImpression.document.write(`
            <html>
            <head>
                <title>Impression Emploi du Temps</title>
                <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Inclure les styles -->
                <style>
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    th, td {
                        border: 1px solid #dee2e6;
                        padding: 8px;
                        text-align: center;
                    }
                    th {
                        background-color: #f8f9fa;
                    }
                </style>
            </head>
            <body>
                ${contenu}
                <script>window.print(); window.close();<\/script>
            </body>
            </html>
        `);
        fenetreImpression.document.close();
    });
</script>
@endsection
