<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin - {{ $eleve->nom }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            line-height: 1.5;
        }

        .header img {
            width: 60px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            text-align: center;
            padding: 6px;
        }

        .observations {
            font-size: 14px;
            font-weight: bold;
            color: red;
            text-align: left;
            padding-top: 10px;
        }

        .summary {
            margin-top: 10px;
        }

        .summary p {
            margin: 4px 0;
        }

        .signatures {
            margin-top: 40px;
        }

        .signatures td {
            text-align: center;
            padding: 30px 0;
        }

        .highlight {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <p><strong>République Islamique de Mauritanie</strong><br>
        Ministère de l’Éducation Nationale</p>
        <h2><u>Bulletin Scolaire</u></h2>
    </div>

    <p><strong>Nom :</strong> {{ $eleve->nom }} {{ $eleve->prenom }}</p>
    <p><strong>Classe :</strong> {{ $eleve->classe->nom ?? '-' }}</p>

    <table>
        <thead>
            <tr>
                <th>Observations</th>
                <th>Les matières</th>
                <th>Les résultats</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 0;
                $totalNote = 0;
                $totalCoeff = 0;
                $matiereList = $matieres;
            @endphp

            @foreach($matiereList as $matiere)
                @php
                    $note = array_sum($matiere['notes']);
                    $coeff = $matiere['coefficient'];
                    $moy = number_format($matiere['moyenne'], 2);
                    $totalNote += $note;
                    $totalCoeff += $coeff;
                @endphp
                <tr>
                    @if($i == 0)
                        <td rowspan="{{ count($matiereList) + (15 - count($matiereList)) }}">Réussite<br>Travail excellent</td>
                    @endif
                    <td>{{ $matiere['nom'] }}</td>
                    <td>{{ $note }}/{{ $coeff * 10 }}</td>
                </tr>
                @php $i++; @endphp
            @endforeach

            {{-- Ajouter des lignes vides jusqu’à 15 lignes --}}
            @for($j = $i; $j < 15; $j++)
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
        </tbody>
    </table>

    <div class="summary">
        <p><strong>Décision Conseil des enseignants :</strong> <span class="highlight">Réussite - Travail excellent</span></p>
        <p><strong>Note totale :</strong> {{ $totalNote }} / {{ $totalCoeff * 10 }}</p>
        <p><strong>Moyenne générale :</strong> {{ $moyenneGenerale }} / 10</p>
        <p><strong>Rang :</strong> 1</p>
    </div>

    <div class="signatures">
        <table width="100%">
            <tr>
                <td>Le Maître</td>
                <td>Le Directeur</td>
            </tr>
        </table>
    </div>

</body>
</html>
