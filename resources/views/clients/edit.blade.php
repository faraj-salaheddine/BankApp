@extends('layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/clients.css') }}">
@endsection

@section('content')
<div class="container-client">

    <div class="client-card">
        <h2 class="client-title">Modifier un client</h2>

        <form action="{{ route('clients.update', $client->id) }}" method="POST" class="client-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="nom" value="{{ $client->nom }}" required>
            </div>

            <div class="form-group">
                <label>Prénom</label>
                <input type="text" name="prenom" value="{{ $client->prenom }}" required>
            </div>

            <div class="form-group">
                <label>CIN</label>
                <input type="text" name="cin" value="{{ $client->cin }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ $client->email }}" required>
            </div>

            <div class="form-group">
                <label>Adresse</label>
                <input type="text" name="adresse" value="{{ $client->adresse }}" required>
            </div>

            <button type="submit" class="btn-save">Mettre à jour</button>
        </form>
    </div>

</div>
@endsection
