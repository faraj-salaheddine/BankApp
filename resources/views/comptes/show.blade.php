@extends('layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/compte.css') }}">
@endsection

@section('content')
<div class="details-wrapper">
    <div class="details-header">
        <a href="{{ route('comptes.index') }}" class="back-link">
            <i data-lucide="arrow-left"></i>
            Retour aux comptes
        </a>
        <h1 class="details-title">
            <i data-lucide="file-text" class="icon-title"></i>
            Compte #{{ $compte->id }}
        </h1>
    </div>

    <div class="details-grid">
        <!-- Carte principale du compte -->
        <div class="detail-card card-primary">
            <div class="card-icon">
                <i data-lucide="credit-card" class="icon-large"></i>
            </div>
            <h2 class="card-title">Informations du compte</h2>
            
            <div class="info-row">
                <span class="info-label">
                    <i data-lucide="fingerprint" class="icon-xs"></i>
                    RIB
                </span>
                <span class="info-value rib-value">{{ $compte->rib }}</span>
            </div>

            <div class="info-row highlight">
                <span class="info-label">
                    <i data-lucide="wallet" class="icon-xs"></i>
                    Solde disponible
                </span>
                <span class="info-value solde-value">{{ number_format($compte->solde, 2, ',', ' ') }} DH</span>
            </div>

            <div class="info-row">
                <span class="info-label">
                    <i data-lucide="calendar" class="icon-xs"></i>
                    Date de création
                </span>
                <span class="info-value">{{ $compte->created_at->format('d/m/Y à H:i') }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">
                    <i data-lucide="clock" class="icon-xs"></i>
                    Dernière modification
                </span>
                <span class="info-value">{{ $compte->updated_at->format('d/m/Y à H:i') }}</span>
            </div>
        </div>

        <!-- Carte client -->
        <div class="detail-card card-secondary">
            <div class="card-icon">
                <i data-lucide="user-circle" class="icon-large"></i>
            </div>
            <h2 class="card-title">Titulaire du compte</h2>
            
            <div class="client-profile">
                <div class="client-avatar-large">
                    <i data-lucide="user" class="icon-avatar-large"></i>
                </div>
                <div class="client-info-block">
                    <h3 class="client-name-large">{{ $compte->client->nom }} {{ $compte->client->prenom }}</h3>
                    <p class="client-meta">
                        <i data-lucide="credit-card" class="icon-xs"></i>
                        CIN: {{ $compte->client->cin }}
                    </p>
                </div>
            </div>

            <div class="info-row">
                <span class="info-label">
                    <i data-lucide="map-pin" class="icon-xs"></i>
                    Adresse
                </span>
                <span class="info-value">{{ $compte->client->adresse }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">
                    <i data-lucide="phone" class="icon-xs"></i>
                    Téléphone
                </span>
                <span class="info-value">{{ $compte->client->telephone ?? 'Non renseigné' }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">
                    <i data-lucide="mail" class="icon-xs"></i>
                    Email
                </span>
                <span class="info-value">{{ $compte->client->email ?? 'Non renseigné' }}</span>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="quick-actions">
        <a href="{{ route('comptes.edit', $compte->id) }}" class="action-btn btn-edit">
            <i data-lucide="edit-3"></i>
            Modifier
        </a>

        <form action="{{ route('comptes.destroy', $compte->id) }}" method="POST" class="delete-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="action-btn btn-delete" onclick="return confirm('⚠️ Cette action est irréversible. Confirmer la suppression ?')">
                <i data-lucide="trash-2"></i>
                Supprimer
            </button>
        </form>
    </div>
</div>
@endsection
