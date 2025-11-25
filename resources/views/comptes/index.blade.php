@extends('layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/compte.css') }}">
@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <i data-lucide="credit-card" class="icon-title"></i>
                Gestion des comptes
            </h1>
            <p class="page-subtitle">
                <i data-lucide="database" class="icon-inline"></i>
                {{ $comptes->count() }} compte(s) enregistré(s)
            </p>
        </div>
        <a href="{{ route('comptes.create') }}" class="btn-primary">
            <i data-lucide="plus-circle"></i>
            Nouveau compte
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i data-lucide="check-circle" class="alert-icon"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="comptes-grid">
        @forelse($comptes as $compte)
        <div class="compte-card">
            <div class="card-header">
                <div class="card-id">
                    <i data-lucide="hash" class="icon-xs"></i>
                    {{ $compte->id }}
                </div>
                <div class="card-badge">
                    <i data-lucide="fingerprint" class="icon-xs"></i>
                    {{ $compte->rib }}
                </div>
            </div>

            <div class="card-body">
                <div class="client-info">
                    <div class="client-avatar">
                        <i data-lucide="user" class="icon-avatar"></i>
                    </div>
                    <div class="client-details">
                        <h3 class="client-name">{{ $compte->client->nom }} {{ $compte->client->prenom }}</h3>
                        <p class="client-cin">
                            <i data-lucide="credit-card" class="icon-xs"></i>
                            CIN: {{ $compte->client->cin }}
                        </p>
                    </div>
                </div>

                <div class="solde-container">
                    <span class="solde-label">
                        <i data-lucide="wallet" class="icon-xs"></i>
                        Solde disponible
                    </span>
                    <span class="solde-amount">{{ number_format($compte->solde, 2, ',', ' ') }} DH</span>
                </div>
            </div>

            <div class="card-actions">
                <a href="{{ route('comptes.show', $compte->id) }}" class="btn-action btn-view" title="Voir les détails">
                    <i data-lucide="eye"></i>
                </a>
                <a href="{{ route('comptes.edit', $compte->id) }}" class="btn-action btn-edit" title="Modifier">
                    <i data-lucide="edit-3"></i>
                </a>
                <form action="{{ route('comptes.destroy', $compte->id) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce compte ?')" title="Supprimer">
                        <i data-lucide="trash-2"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i data-lucide="folder-open" class="empty-icon"></i>
            <h3>Aucun compte disponible</h3>
            <p>Commencez par créer votre premier compte bancaire</p>
            <a href="{{ route('comptes.create') }}" class="btn-primary">
                <i data-lucide="plus-circle"></i>
                Créer un compte
            </a>
        </div>
        @endforelse
    </div>
</div>

@endsection