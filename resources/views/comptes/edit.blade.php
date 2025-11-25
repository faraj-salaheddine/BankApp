@extends('layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/compte.css') }}">
@endsection

@section('content')
<div class="container">

    <h1>Modifier le compte</h1>

    <form action="{{ route('comptes.update', $compte->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>RIB :</label>
            <input type="text" name="rib" class="form-control"
                   value="{{ $compte->rib }}" required>
        </div>

        <div class="mb-3">
            <label>Solde :</label>
            <input type="number" name="solde" class="form-control"
                   value="{{ $compte->solde }}" required>
        </div>

        <div class="mb-3">
            <label>Client :</label>
            <select name="client_id" class="form-control" required>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}"
                        {{ $client->id == $compte->client_id ? 'selected' : '' }}>
                        {{ $client->nom }} {{ $client->prenom }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('comptes.index') }}" class="btn btn-secondary">Annuler</a>
    </form>

</div>
@endsection
