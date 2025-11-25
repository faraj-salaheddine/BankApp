@extends('layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/clients.css') }}">
@endsection

@section('content')
<div class="container-client">

    <div class="client-card">
        <h2 class="client-title">Ajouter un client</h2>

        <form action="{{ route('clients.store') }}" method="POST" class="client-form">
            @csrf

            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="nom" required>
            </div>

            <div class="form-group">
                <label>Prénom</label>
                <input type="text" name="prenom" required>
            </div>

            <div class="form-group">
                <label>CIN</label>
                <input type="text" name="cin" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Adresse</label>
                <input type="text" name="adresse" required>
            </div>

            <button type="submit" class="btn-save">Enregistrer</button>
        </form>
    </div>

</div>
@endsection
