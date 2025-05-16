@extends('layouts.app')

@section('content')
    <div class="container  ">
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

        <form action="{{ route('enseignements.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
           <!-- Champ caché pour stocker l'année scolaire -->
          
            <!-- Row 1: Nom, Prénom, Sexe  -->
            <div class="form-row form-section">
                <div class="form-group col-md-4">
                    <label for="nom">Nom: <b style="color:red;">*</b></label>
                    <input type="text" name="nom" class="form-control" id="nom" placeholder="Votre nom" value="{{ old('nom') }}" required>
                </div> 
                <div class="form-group col-md-4">
                    <label for="prenom">Prénom: <b style="color:red;">*</b></label>
                    <input type="text" name="prenom" class="form-control" id="prenom" placeholder="Prénom de l'élève" value="{{ old('prenom') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="sexe">Sexe:</label><br>
                    <select name="sexe" id="sexe"  class="form-control" required>
                        <option value="Masculin" {{ old('sexe') == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                        <option value="Féminin" {{ old('sexe') == 'Féminin' ? 'selected' : '' }}>Féminin</option>
                    </select>
                </div>
            </div>
            <!-- Row 2: Date de Naissance , Lieu de Naissance ,Numéro téléphone  -->
            <div class="form-row form-section">
                <div class="form-group col-md-4">
                    <label for="date_naissance">Date de Naissance: <b style="color:red;">*</b></label>
                    <input type="date" name="date_naissance" class="form-control" id="date_naissance" value="{{ old('date_naissance') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="lieux_naissance">Lieu de Naissance: <b style="color:red;">*</b></label>
                    <input type="text" name="lieux_naissance" class="form-control" id="lieux_naissance" placeholder="Lieu de naissance" value="{{ old('lieux_naissance') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="telephone">Numéro téléphone : <b style="color:red;">*</b> </label>
                    <input type="tel" name="telephone" class="form-control" id="telephone" placeholder="Entrer numéro de tel " value="{{ old('telephone') }}">
                </div>
            </div>
             <!-- Row 3: Nationalité ,  Email ,Diplome  -->
             <div class="form-row form-section">
                <div class="form-group col-md-4">
                    <label for="nationalite">Nationalité: <b style="color:red;">*</b></label>
                    <input type="text" name="nationalite" class="form-control" id="nationalite" placeholder="Entrer nationalité" value="{{ old('nationalite') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="email">Email : <b style="color:red;">*</b> </label>
                    <input type="tel" name="email" class="form-control" id="email" placeholder="Entrer Email" value="{{ old('email') }}">
                 </div> 
                <div class="form-group col-md-4">
                    <label for="diplome">Diplome: <b style="color:red;">*</b></label>
                    <select name="diplome" class="form-control" id="diplome" required>
                        <option value="Bac" {{ old('diplome') == 'Bac' ? 'selected' : '' }}>Bac</option>
                        <option value="Licence" {{ old('diplome') == 'Licence' ? 'selected' : '' }}>Licence</option>
                        <option value="Master" {{ old('diplome') == 'Master' ? 'selected' : '' }}>Master</option>
                        <option value="Doctorat" {{ old('diplome') == 'Doctorat' ? 'selected' : '' }}>Doctorat</option>
                    </select>
                </div> 
            </div>
            <!-- Row 3:   Type contrat , Debut contrat ,Fin  contrat -->
            <div class="form-row form-section">
                
                <div class="form-group col-md-4">
                    <label for="type_contrat">Type contrat: <b style="color:red;">*</b></label><br>
                    <select name="type_contrat" id="type_contrat"  class="form-control" required>
                        <option value="CDD" {{ old('type_contrat') == 'CDD' ? 'selected' : '' }}>CDD</option>
                        <option value="CDI" {{ old('type_contrat') == 'CDI' ? 'selected' : '' }}>CDI</option>
                     </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="debut_contrat">Debut contrat: <b style="color:red;">*</b></label>
                    <input type="date" name="debut_contrat" class="form-control" id="debut_contrat" value="{{ old('debut_contrat') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="fin_contrat">Fin  contrat:  </label>
                    <input type="date" name="fin_contrat" class="form-control" id="fin_contrat" value="{{ old('fin_contrat') }}" required>
                </div>
            </div>
            <!-- Champ pour télécharger la photo -->
            <div class="form-row form-section">
                <div class="form-group col-md-3">
                    <label for="salaire">Salaire:</label>
                    <input type="Number" class="form-control" id="salaire" name="salaire" value="{{ old('salaire') }}" required >
                </div>
                <div class="form-group col-md-4">
                    <label for="photo">Photo:</label>
                    <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*" onchange="previewPhoto()">
                </div>
                <div class="form-group col-md-5">
                    <!-- Aperçu de la photo -->
                    <label>Prévisualisation de la photo:</label>
                    <div class="photo-container">
                        <img id="photoPreview" class="photo-preview rounded-circle" src="" alt="Aperçu de la photo">
                    </div>
                     
                </div>
                <button type="submit" class="btn btn-primary btn-block">Ajouter </button>
            </div>
            
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
