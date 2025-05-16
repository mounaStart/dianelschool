<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Emplois du Temps - {{ $classe->nom }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Emplois du Temps - Classe : {{ $classe->nom }}</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Heure Début</th>
                <th>Heure Fin</th>
                <th>Cours</th>
                <th>Salle</th>
                <th>Enseignant</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classe->emploisDuTemps as $emploi)
                <tr>
                    <td>{{ $emploi->date }}</td>
                    <td>{{ $emploi->heure_debut }}</td>
                    <td>{{ $emploi->heure_fin }}</td>
                    <td>{{ $emploi->cours->matiere->nom }}</td>
                    <td>{{ $emploi->salle->nom }}</td>
                    <td>{{ $emploi->enseignement->nom }} {{ $emploi->enseignement->prenom }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
