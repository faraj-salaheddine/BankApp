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
                <i data-lucide="file-plus" class="icon-title"></i>
                Nouveau compte bancaire
            </h1>
            <p class="form-description">
                <i data-lucide="info" class="icon-inline"></i>
                Créez un nouveau compte pour un client existant
            </p>
        </div>

        <form action="{{ route('comptes.store') }}" method="POST" class="modern-form">
            @csrf

            <div class="form-group">
                <label for="rib" class="form-label">
                    <span class="label-text">
                        <i data-lucide="fingerprint" class="icon-xs"></i>
                        RIB (Relevé d'Identité Bancaire)
                    </span>
                    <span class="label-required">*</span>
                </label>
                <div class="input-wrapper">
                    <i data-lucide="key" class="input-icon"></i>
                    <input 
                        type="text" 
                        name="rib" 
                        id="rib"
                        class="form-input" 
                        placeholder="Ex: 230 780 000 123456789012"
                        pattern="[0-9 ]{24,}"
                        required
                    >
                </div>
                <small class="form-hint">
                    <i data-lucide="alert-circle" class="icon-xs"></i>
                    Format: 24 chiffres avec ou sans espaces
                </small>
            </div>

            <div class="form-group">
                <label for="solde" class="form-label">
                    <span class="label-text">
                        <i data-lucide="wallet" class="icon-xs"></i>
                        Solde initial
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
                        placeholder="0.00"
                        step="0.01"
                        min="0"
                        required
                    >
                    <span class="input-suffix">DH</span>
                </div>
            </div>

            <div class="form-group">
                <label for="client_id" class="form-label">
                    <span class="label-text">
                        <i data-lucide="user-check" class="icon-xs"></i>
                        Titulaire du compte
                    </span>
                    <span class="label-required">*</span>
                </label>
                <div class="input-wrapper">
                    <i data-lucide="users" class="input-icon"></i>
                    <select name="client_id" id="client_id" class="form-select" required>
                        <option value="">-- Sélectionner un client --</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">
                                {{ $client->nom }} {{ $client->prenom }} — CIN: {{ $client->cin }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i data-lucide="check-circle"></i>
                    Créer le compte
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
