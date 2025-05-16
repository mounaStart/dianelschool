@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Notes des enfants</h2>
   
    @forelse ($enfants as $enfant)
        <div class="card mt-4">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span>
                {{ $enfant->prenom }} {{ $enfant->nom }} - Classe : {{ $enfant->classe->nom ?? 'Non défini' }}
            </span>
            <a href="{{ route('bulletin.pdf', $enfant->id) }}" class="btn btn-sm btn-light text-primary" title="Télécharger le bulletin" target="_blank">
                <i class="fas fa-download"></i>
            </a>
        </div>

            <div class="card-body">
            
                @if ($enfant->notes->isNotEmpty())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Matière</th>
                                <th>Note</th>
                                <th>Évaluation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enfant->notes as $note)
                                <tr>
                                    <td>{{ $note->evaluation->matiere->nom ?? '-' }}</td>
                                    <td>{{ $note->note }}</td>
                                    <td>{{ $note->evaluation->titre ?? '-' }}</td>
                                     
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Aucune note enregistrée.</p>
                @endif
            </div>
        </div>
    @empty
        <p>Aucun enfant trouvé.</p>
    @endforelse
</div>
@endsection
