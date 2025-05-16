@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Formulaire d'inscription</h2>

        <!-- Affichage des erreurs de validation -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('eleves.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
           <!-- Champ caché pour stocker l'année scolaire -->
           
<input type="hidden" name="annee_scolaire_id" value="{{ request('annee_scolaire_id') }}">

            <!-- Row 1: Nom, Prénom, Classe -->
            <div class="form-row form-section">
                <div class="form-group col-md-2">
                    <label for="nom">Nom: <b style="color:red;">*</b></label>
                    <input type="text" name="nom" class="form-control" id="nom" placeholder="Votre nom" value="{{ old('nom') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="prenom">Prénom: <b style="color:red;">*</b></label>
                    <input type="text" name="prenom" class="form-control" id="prenom" placeholder="Prénom de l'élève" value="{{ old('prenom') }}" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="adresse">Adresse: <b style="color:red;">*</b></label>
                    <input type="text" name="adresse" class="form-control" id="adresse" placeholder="Entrez adresse" value="{{ old('adresse') }}" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="sexe">Sexe:</label><br>
                    <select name="sexe" class="form-control" required>
                        <option value="Masculin" {{ old('sexe') == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                        <option value="Féminin" {{ old('sexe') == 'Féminin' ? 'selected' : '' }}>Féminin</option>
                    </select>
                </div>
            </div>
            <div class="form-row form-section">
                <div class="form-group col-md-3">
                    <label for="date_naissance">Date de Naissance: <b style="color:red;">*</b></label>
                    <input type="date" name="date_naissance" class="form-control" id="date_naissance" value="{{ old('date_naissance') }}" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="lieux_naissance">Lieu de Naissance: <b style="color:red;">*</b></label>
                    <input type="text" name="lieux_naissance" class="form-control" id="lieux_naissance" placeholder="Lieu de naissance" value="{{ old('lieux_naissance') }}" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="numero_national">Numéro National: <b style="color:red;">*</b></label>
                    <input type="text" name="numero_national" class="form-control" id="numero_national" placeholder="Numéro national" value="{{ old('numero_national') }}" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="nationalite">Nationalité: <b style="color:red;">*</b></label>
                    <input type="text" name="nationalite" class="form-control" id="nationalite" placeholder="Entrer nationalité" value="{{ old('nationalite') }}" required>
                </div>
            </div>

            <!-- Row 2: Type élève, Moyen de Transport -->
            <div class="form-row form-section">
                <div class="form-group col-md-4">
                    <label for="type_eleve">Type élève: <b style="color:red;">*</b></label><br>
                    <select name="type_eleve" class="form-control" required>
                        <option value="Passant" {{ old('type_eleve') == 'Passant' ? 'selected' : '' }}>Passant</option>
                        <option value="Nouveau" {{ old('type_eleve') == 'Nouveau' ? 'selected' : '' }}>Nouveau</option>
                        <option value="Redoublant" {{ old('type_eleve') == 'Redoublant' ? 'selected' : '' }}>Redoublant</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="moyen_transport">Moyen de Transport: <b style="color:red;">*</b></label><br>
                    <select name="moyen_transport" class="form-control" required>
                        <option value="Public" {{ old('moyen_transport') == 'Public' ? 'selected' : '' }}>Public</option>
                        <option value="Privé" {{ old('moyen_transport') == 'Privé' ? 'selected' : '' }}>Privé</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="classe_id">Classe: <b style="color:red;">*</b></label>
                    <select name="classe_id" class="form-control" required>
                        @foreach ($classes as $classe)
                            <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
                        @endforeach
                    </select>
                </div>
              
            </div>
            <!-- Row 5: Téléphone 2, Nom des Parents -->
            <div class="form-row form-section">
                <div class="form-group col-md-4">
                    <label for="nomParent">Nom Parent: <b style="color:red;">*</b></label>
                    <input type="text" name="nomParent" class="form-control" id="nomParent" placeholder="Nom des parents" value="{{ old('nomParent') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="prenomParent">Prénom Parent: <b style="color:red;">*</b></label>
                    <input type="text" name="prenomParent" class="form-control" id="prenomParent" placeholder="Prenom des parents" value="{{ old('prenomParent') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="relation">Relation : <b style="color:red;">*</b></label><br>
                    <select name="relation" class="form-control" id="relation" required>
                        <option value="Père" {{ old('relation') == 'Père' ? 'selected' : '' }}>Père</option>
                        <option value="Mère" {{ old('relation') == 'Mère' ? 'selected' : '' }}>Mère</option>
                        <option value="Tuteur" {{ old('relation') == 'Tuteur' ? 'selected' : '' }}>Tuteur</option>
                    </select>
                </div>
            </div>
            <div class="form-row form-section">
                <div class="form-group col-md-6">
                    <label for="telephone">Numéro téléphone : <b style="color:red;">*</b> </label>
                    <input type="tel" name="telephone" class="form-control" id="telephone" placeholder="Entrer numéro de tel " value="{{ old('telephone') }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Email : <b style="color:red;">*</b> </label>
                    <input type="tel" name="email" class="form-control" id="email" placeholder="Entrer Email" value="{{ old('email') }}">
                    <input type="hidden" name="parent_id" class="form-control" id="parent_id" placeholder="Entrer numéro de tel 2" value="{{ old('parent_id') }}">
                </div>
                

            <!-- Champ pour télécharger la photo -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="photo">Photo:</label>
                    <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*" onchange="previewPhoto()">
                </div>
                <div class="form-group col-md-6">
                    <!-- Aperçu de la photo -->
                    <label>Prévisualisation de la photo:</label>
                    <img id="photoPreview" class="photo-preview" src="" alt="Aperçu de la photo">
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Inscrire</button>
        </form>
    </div>

    <script>
        function previewPhoto() {
            const file = document.getElementById('photo').files[0];
            const preview = document.getElementById('photoPreview');
            const reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
    </script>
@endsection
