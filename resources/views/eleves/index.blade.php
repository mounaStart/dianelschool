@extends('layouts.app')

@section('content')
<!-- Formulaire de recherche stylisé -->
<form method="GET" action="{{ route('eleves.index') }}" class="mb-4 p-3 bg-light rounded shadow-sm">
    <h5 class="mb-3">Rechercher un élève</h5>
    <div class="form-row">
        <div class="col-md-3 mb-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-white"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" name="nom" class="form-control" placeholder="Nom" value="{{ request('nom') }}">
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-white"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" name="prenom" class="form-control" placeholder="Prénom" value="{{ request('prenom') }}">
            </div>
        </div>
        <div class="col-md-2 mb-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-white"><i class="fas fa-venus-mars"></i></span>
                </div>
                <select name="sexe" class="form-control">
                    <option value="">Genre</option>
                    <option value="Masculin" {{ request('sexe') == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                    <option value="Féminin" {{ request('sexe') == 'Féminin' ? 'selected' : '' }}>Féminin</option>
                </select>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-white"><i class="fas fa-globe"></i></span>
                </div>
                <input type="text" name="nationalite" class="form-control" placeholder="Nationalité" value="{{ request('nationalite') }}">
            </div>
        </div>
        <div class="col-md-1 mb-2 d-flex align-items-center">
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Rechercher</button>
        </div>
    </div>
</form>

<div class="container mt-5">
    <div class="row mb-4">
        <!-- Menu déroulant à gauche -->
        <div class="col-md-6">
            <a href="#actionSubmenu" data-toggle="collapse" aria-expanded="false" class="btn btn-secondary dropdown-toggle">
                <i class="fas fa-users"></i> Actions
            </a>
            <ul class="collapse list-unstyled submenu-links" id="actionSubmenu">
                <li><a href="{{ route('eleves.index') }}" class="submenu-item">Imprimer</a></li>
                <li><a href="{{ route('eleves.create') }}" class="submenu-item">Nouvelle photo</a></li>
                <li><a href="{{ route('eleves.create') }}" class="submenu-item">Payer scolarité</a></li>
            </ul>
        </div>

        <!-- Bouton Ajouter Élève à droite -->
        <div class="col-md-6 text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#anneeScolaireModal">
                <i class="fas fa-plus"></i> Ajouter Élève
            </button>
        </div>
    </div>

    <!-- Modal de sélection d'année scolaire -->
    <div class="modal fade" id="anneeScolaireModal" tabindex="-1" role="dialog" aria-labelledby="anneeScolaireModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="anneeScolaireModalLabel">Sélectionnez l'année scolaire</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="anneeScolaireForm" method="GET" action="{{ route('eleves.create') }}">
                        <div class="form-group">
                            <label for="annee_scolaire_id">Année Scolaire</label>
                            <select name="annee_scolaire_id" id="annee_scolaire_id" class="form-control" required>
                                <option value="">Sélectionnez une année</option>
                                @foreach($anneesScolaires as $annee)
                                    <option value="{{ $annee->id }}">{{ $annee->annee_scolaire }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Continuer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau d'élèves -->
    <div class="table-responsive">
    <a href="{{ route('bulletins.tous.pdf') }}" class="btn btn-success mb-3" target="_blank">
    Imprimer Tous les Bulletins
</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Sexe</th>
                    <th>Nationalité</th>
                    <th>Classe</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($eleves as $eleve)
                <tr>
                    <td>{{ $eleve->nom }}</td>
                    <td>{{ $eleve->prenom }}</td>
                    <td>{{ $eleve->sexe }}</td>
                    <td>{{ $eleve->nationalite }}</td>
                    <td>{{ $eleve->classe->nom }}</td>
                    <td>
                        <a href="{{ route('eleves.show', $eleve->id) }}" class="btn btn-info btn-sm">Détails</a>
                        <a href="{{ route('eleves.edit', $eleve->id) }}" class="btn btn-warning btn-sm">Éditer</a>
                        <a href="{{ route('eleves.suspend', $eleve->id) }}" title="Suspendre" style="margin-left: 10px;">
                            <i class="fas fa-ban text-danger"></i>
                        </a>
                        <form action="{{ route('eleves.destroy', $eleve->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet élève?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                         <!-- Bouton pour générer et télécharger le bulletin PDF -->
         <a href="{{ route('bulletin.pdf', $eleve->id) }}" class="btn btn-success" target="_blank">
                    Imprimer le Bulletin
                </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
