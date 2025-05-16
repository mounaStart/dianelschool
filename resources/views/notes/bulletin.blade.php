<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bulletin de {{ $eleve->nom }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Bulletin de {{ $eleve->nom }} {{ $eleve->prenom }}</h2>
    <h3>Classe : {{ $eleve->classe->nom }}</h3>

    <table>
        <thead>
            <tr>
                <th>Matière</th>
                <th>Notes</th>
                <th>Coefficient</th>
                <th>Moyenne</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($matieres as $matiere)
                <tr>
                    <td>{{ $matiere['nom'] }}</td>
                    <td>
                        @foreach($matiere['notes'] as $note)
                            {{ $note }} -
                        @endforeach
                    </td>
                    <td>{{ $matiere['coefficient'] }}</td>
                    <td>{{ $matiere['moyenne'] }}</td>
                    
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Moyenne Générale</th>
                <th colspan="2">{{ $moyenneGenerale }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
