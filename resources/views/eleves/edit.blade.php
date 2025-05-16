@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Modifier les informations de l'élève</h2>

        <form action="{{ route('eleves.update', $eleve->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Row 1: Nom, Prénom, Classe -->
            <div class="form-row form-section">
                <div class="form-group col-md-4">
                    <label for="nom">Nom: <b style="color:red;">*</b></label>
                    <input type="text" name="nom" class="form-control" id="nom" value="{{ $eleve->nom }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="prenom">Prénom: <b style="color:red;">*</b></label>
                    <input type="text" name="prenom" class="form-control" id="prenom" value="{{ $eleve->prenom }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="classe_id">Classe: <b style="color:red;">*</b></label>
                    <select name="classe_id" class="form-control" required>
                        @foreach ($classes as $classe)
                            <option value="{{ $classe->id }}" {{ $eleve->classe_id == $classe->id ? 'selected' : '' }}>
                                {{ $classe->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Row 2: Type élève, Moyen de Transport -->
            <div class="form-row form-section">
                <div class="form-group col-md-4">
                    <label for="type_eleve">Type élève: <b style="color:red;">*</b></label><br>
                    <select name="type_eleve" class="form-control" required>
                        <option value="Passant" {{ $eleve->type_eleve == 'Passant' ? 'selected' : '' }}>Passant</option>
                        <option value="Nouveau" {{ $eleve->type_eleve == 'Nouveau' ? 'selected' : '' }}>Nouveau</option>
                        <option value="Redoublant" {{ $eleve->type_eleve == 'Redoublant' ? 'selected' : '' }}>Redoublant</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="moyen_transport">Moyen de Transport: <b style="color:red;">*</b></label><br>
                    <select name="moyen_transport" class="form-control" required>
                        <option value="Public" {{ $eleve->moyen_transport == 'Public' ? 'selected' : '' }}>Public</option>
                        <option value="Privé" {{ $eleve->moyen_transport == 'Privé' ? 'selected' : '' }}>Privé</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="adresse">Adresse: <b style="color:red;">*</b></label>
                    <input type="text" name="adresse" class="form-control" id="adresse" value="{{ $eleve->adresse }}" required>
                </div>
            </div>

            <!-- Row 3: Numéro National, Sexe, Nationalité -->
            <div class="form-row form-section">
                <div class="form-group col-md-4">
                    <label for="numero_national">Numéro National: <b style="color:red;">*</b></label>
                    <input type="text" name="numero_national" class="form-control" id="numero_national" value="{{ $eleve->numero_national }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="sexe">Sexe:</label><br>
                    <select name="sexe" class="form-control" required>
                        <option value="Masculin" {{ $eleve->sexe == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                        <option value="Féminin" {{ $eleve->sexe == 'Féminin' ? 'selected' : '' }}>Féminin</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="nationalite">Nationalité: <b style="color:red;">*</b></label>
                    <input type="text" name="nationalite" class="form-control" id="nationalite" value="{{ $eleve->nationalite }}" required>
                </div>
            </div>

            <!-- Row 4: Date de Naissance, Lieu de Naissance, Téléphone 1 -->
            <div class="form-row form-section">
                <div class="form-group col-md-4">
                    <label for="date_naissance">Date de Naissance: <b style="color:red;">*</b></label>
                    <input type="date" name="date_naissance" class="form-control" id="date_naissance" value="{{ $eleve->date_naissance }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="lieux_naissance">Lieu de Naissance: <b style="color:red;">*</b></label>
                    <input type="text" name="lieux_naissance" class="form-control" id="lieux_naissance" value="{{ $eleve->lieux_naissance }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="telephone1">Numéro téléphone 1: <b style="color:red;">*</b></label>
                    <input type="tel" name="telephone1" class="form-control" id="telephone1" value="{{ $eleve->telephone1 }}" required>
                </div>
            </div>

            <!-- Row 5: Téléphone 2, Nom des Parents -->
            <div class="form-row form-section">
                <div class="form-group col-md-4">
                    <label for="telephone2">Numéro téléphone 2: </label>
                    <input type="tel" name="telephone2" class="form-control" id="telephone2" value="{{ $eleve->telephone2 }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="parent_id">Nom Parents:<b style="color:red;">*</b></label>
                    <input type="text" name="parent_id" class="form-control" id="parent_id" value="{{ $eleve->parent_id }}" required>
                </div>
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
                    <img id="photoPreview" class="photo-preview" src="{{ asset($eleve->photo) }}" alt="Aperçu de la photo">
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Mettre à jour</button>
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
                preview.src = "{{ asset($eleve->photo) }}";
            }
        }
    </script>
@endsection
