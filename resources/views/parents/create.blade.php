@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Ajouter un parent</h3>
    <form action="{{ route('parents.store') }}" method="POST">
        @include('parents.form')
    </form>
</div>
@endsection
