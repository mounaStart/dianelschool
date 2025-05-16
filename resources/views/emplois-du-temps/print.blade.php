<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimer Emploi du Temps</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
            color: #000;
        }
        .container {
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .table th {
            background: #f4f4f4;
        }
        .no-print {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Emploi du Temps</h1>
            <h2>Classe : {{ $emploiDuTemps->classe->nom }}</h2>
            <p>Date : {{ $emploiDuTemps->date }}</p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Heure Début</th>
                    <th>Heure Fin</th>
                    <th>Cours</th>
                    <th>Enseignant</th>
                    <th>Salle</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $emploiDuTemps->heure_debut }}</td>
                    <td>{{ $emploiDuTemps->heure_fin }}</td>
                    <td>{{ $emploiDuTemps->cours->matiere->nom }}</td>
                    <td>{{ $emploiDuTemps->cours->enseignement->nom }}</td>
                    <td>{{ $emploiDuTemps->salle->nom }}</td>
                </tr>
            </tbody>
        </table>

        <button class="no-print" onclick="window.print()">Imprimer</button>
    </div>
</body>
</html>
