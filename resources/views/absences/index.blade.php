@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Liste des absences et retards</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('absences.create') }}" class="btn btn-primary mb-3">Nouvelle absence/retard</a>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Élève</th>
                <th>Classe</th>
                <th>Date</th>
                <th>Type</th>
                <th>Motif</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absences as $absence)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $absence->eleve->nom }} {{ $absence->eleve->prenom }}</td>
                    <td>{{ $absence->eleve->classe->nom ?? 'Non défini' }}</td>
                    <td>{{ \Carbon\Carbon::parse($absence->date)->format('d/m/Y') }}</td>
                    <td>
                        @if($absence->type === 'absence')
                            <span class="badge bg-danger">Absence</span>
                        @else
                            <span class="badge bg-warning text-dark">Retard</span>
                        @endif
                    </td>
                    <td>{{ $absence->motif ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Aucune absence ou retard enregistré.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
