<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bulletins de tous les élèves</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
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
        h2, h3 {
            text-align: center;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <h1>Bulletins de tous les élèves</h1>

    @foreach($bulletins as $bulletin)
        <h2>Bulletin de {{ $bulletin['eleve']->nom }} {{ $bulletin['eleve']->prenom }}</h2>
        <h3>Classe : {{ $bulletin['eleve']->classe->nom }}</h3>

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
                @foreach($bulletin['matieres'] as $matiere)
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
                    <th colspan="2">{{ $bulletin['moyenneGenerale'] }}</th>
                </tr>
            </tfoot>
        </table>

        <div class="page-break"></div> <!-- Saut de page pour chaque élève -->
    @endforeach
</body>
</html>
