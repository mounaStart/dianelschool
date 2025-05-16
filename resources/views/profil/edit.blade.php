@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Modifier le Profil</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profil.update') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Adresse Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="text" name="telephone" value="{{ old('telephone', $user->telephone) }}" class="form-control">
        </div>

        <hr>

        <h5>Changer le mot de passe</h5>

        <div class="form-group">
            <label for="password">Nouveau mot de passe</label>
            <input type="password" name="password" class="form-control" placeholder="Laisser vide pour ne pas changer">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmation du mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('profil.show') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
