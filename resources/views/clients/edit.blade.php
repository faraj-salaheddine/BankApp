@extends('layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/clients.css') }}">
@endsection

@section('content')
<h2 class="page-title">Modifier le client</h2>

<div class="card-container form-card">
    <form action="{{ route('clients.update', $client->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" class="form-input" value="{{ $client->nom }}" required>
        </div>

        <div class="form-group">
            <label>Prénom</label>
            <input type="text" name="prenom" class="form-input" value="{{ $client->prenom }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-input" value="{{ $client->email }}" required>
        </div>

        <button type="submit" class="btn-main mt-3">Mettre à jour</button>
    </form>
</div>
@endsection
