@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Mon Profil</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>Nom :</strong> {{ $user->name }}</p>
            <p><strong>Email :</strong> {{ $user->email }}</p>
            <p><strong>Téléphone :</strong> {{ $user->telephone ?? 'Non renseigné' }}</p>
            <a href="{{ route('profil.edit') }}" class="btn btn-warning">Modifier</a>
        </div>
    </div>
</div>
@endsection
