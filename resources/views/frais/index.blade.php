@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Liste des frais scolaires</h1>

    <a href="{{ route('frais.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Ajouter un frais
    </a>
    
    <a href="{{ route('factures.index') }}" class="btn btn-success mb-3">
    <i class="fas fa-file-invoice"></i> Générer les Factures
</a>


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Nom</th>
                <th>Montant (MRO)</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($frais as $f)
                <tr>
                    <td>{{ $f->nom }}</td>
                    <td>{{ number_format($f->montant, 2) }}</td>
                    <td>{{ $f->description ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('frais.edit', $f->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <form action="{{ route('frais.destroy', $f->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Voulez-vous vraiment supprimer ce frais ?')">
                                <i class="fas fa-trash-alt"></i> Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
