@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Modifier le parent</h3>
    <form action="{{ route('parents.update', $parent) }}" method="POST">
        @method('PUT')
        @include('parents.form')
    </form>
</div>
@endsection
