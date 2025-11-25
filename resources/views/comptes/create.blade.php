@extends('layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/compte.css') }}">
@endsection

@section('content')
<div class="container">

    <h1>Ajouter un compte</h1>

    <form action="{{ route('comptes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>RIB :</label>
            <input type="text" name="rib" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Solde :</label>
            <input type="number" name="solde" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Client :</label>
            <select name="client_id" class="form-control" required>
                <option value="">-- Sélectionner un client --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">
                        {{ $client->nom }} {{ $client->prenom }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">Enregistrer</button>
        <a href="{{ route('comptes.index') }}" class="btn btn-secondary">Annuler</a>
    </form>

</div>
@endsection
