@if(isset($eleves) && $eleves->isEmpty())
    <p>Aucune note disponible pour cette classe.</p>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Élève</th>
                <th>Moyenne</th>
                <th>Détails</th>
            </tr>
        </thead>
        <tbody>
            @foreach($eleves as $eleve)
                <tr>
                    <td>{{ $eleve->nom }} {{ $eleve->prenom }}</td>
                    <td>{{ $eleve->notes->isNotEmpty() ? number_format($eleve->notes->avg('note'), 2) : 'N/A' }}</td>
                    <td>
                        <a href="{{ route('eleves.show', $eleve->id) }}" class="btn btn-info">Voir détails</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
