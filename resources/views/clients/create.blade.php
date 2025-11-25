@extends('layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/clients.css') }}">
@endsection

@section('content')
<h2 class="page-title">Ajouter un client</h2>

<div class="card-container form-card">
    <form action="{{ route('clients.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" class="form-input" required>
        </div>

        <div class="form-group">
            <label>Prénom</label>
            <input type="text" name="prenom" class="form-input" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-input" required>
        </div>

        <button type="submit" class="btn-main mt-3">Enregistrer</button>
    </form>
</div>
@endsection
