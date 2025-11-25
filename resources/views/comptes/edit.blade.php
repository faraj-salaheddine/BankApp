@extends('layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/compte.css') }}">
@endsection

@section('content')
<div class="form-wrapper">
    <div class="form-container">
        <div class="form-header">
            <a href="{{ route('comptes.index') }}" class="back-link">
                <i data-lucide="arrow-left"></i>
                Retour
            </a>
            <h1 class="form-title">
                <i data-lucide="edit" class="icon-title"></i>
                Modifier le compte #{{ $compte->id }}
            </h1>
            <p class="form-description">
                <i data-lucide="fingerprint" class="icon-inline"></i>
                RIB: {{ $compte->rib }}
            </p>
        </div>

        <form action="{{ route('comptes.update', $compte->id) }}" method="POST" class="modern-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="rib" class="form-label">
                    <span class="label-text">
                        <i data-lucide="key" class="icon-xs"></i>
                        RIB
                    </span>
                    <span class="label-required">*</span>
                </label>
                <div class="input-wrapper">
                    <i data-lucide="fingerprint" class="input-icon"></i>
                    <input 
                        type="text" 
                        name="rib" 
                        id="rib"
                        class="form-input" 
                        value="{{ $compte->rib }}"
                        required
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="solde" class="form-label">
                    <span class="label-text">
                        <i data-lucide="wallet" class="icon-xs"></i>
                        Solde
                    </span>
                    <span class="label-required">*</span>
                </label>
                <div class="input-wrapper">
                    <i data-lucide="dollar-sign" class="input-icon"></i>
                    <input 
                        type="number" 
                        name="solde" 
                        id="solde"
                        class="form-input" 
                        value="{{ $compte->solde }}"
                        step="0.01"
                        required
                    >
                    <span class="input-suffix">DH</span>
                </div>
            </div>

            <div class="form-group">
                <label for="client_id" class="form-label">
                    <span class="label-text">
                        <i data-lucide="user" class="icon-xs"></i>
                        Titulaire
                    </span>
                    <span class="label-required">*</span>
                </label>
                <div class="input-wrapper">
                    <i data-lucide="users" class="input-icon"></i>
                    <select name="client_id" id="client_id" class="form-select" required>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ $client->id == $compte->client_id ? 'selected' : '' }}>
                                {{ $client->nom }} {{ $client->prenom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i data-lucide="save"></i>
                    Mettre à jour
                </button>
                <a href="{{ route('comptes.index') }}" class="btn-cancel">
                    <i data-lucide="x-circle"></i>
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
