@csrf

<div class="mb-3">
    <label for="nom">Nom</label>
    <input type="text" name="nom" value="{{ old('nom', $parent->nom ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label for="prenom">Prénom</label>
    <input type="text" name="prenom" value="{{ old('prenom', $parent->prenom ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label for="telephone">Téléphone</label>
    <input type="text" name="telephone" value="{{ old('telephone', $parent->telephone ?? '') }}" class="form-control">
</div>
<button class="btn btn-success">Enregistrer</button>
