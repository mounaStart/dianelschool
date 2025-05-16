@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-5">Connexion</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">Se souvenir de moi</label>
        </div>
        <button type="submit" class="btn btn-primary">Connexion</button>
    </form>
    <p class="mt-3">Pas encore inscrit? <a href="{{ route('register') }}">Inscrivez-vous ici</a>.</p>
</div>
@endsection
