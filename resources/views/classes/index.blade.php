@extends('layouts.app')

@section('content')
<div class="container mt-5">
       
        <h1>Liste des classes</h1>

        <a href="{{ route('classes.create') }}" class="btn btn-primary mb-3">Ajouter une classe</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Niveau</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $classe)
                    <tr>
                        <td>{{ $classe->nom }}</td>
                        <td>{{ $classe->niveau }}</td>
                        <td>
                            <a href="{{ route('classes.edit', $classe->id) }}" class="btn btn-warning">Modifier</a>
                            <form action="{{ route('classes.destroy', $classe->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                            
                    <a href="{{ route('classes.cours.manage', $classe->id) }}" class="btn btn-primary">Gérer les Cours</a>
                  <!-- <a href="{{ route('classes.emplois-du-temps.print', $classe->id) }}" class="btn btn-primary">Imprimer Emploi du Temps</a>
                        -->
                        <a href="{{ route('classes.emploi_du_temps', $classe->id) }}" class="btn btn-info">Voir Emploi du Temps</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection


@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Classes</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Niveau</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classes as $classe)
            <tr>
                <td>{{ $classe->nom }}</td>
                <td>{{ $classe->niveau }}</td>
                <td>
                    <a href="{{ route('classes.cours.manage', $classe->id) }}" class="btn btn-primary">Gérer les Cours</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

