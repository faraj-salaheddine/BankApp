@extends('layout.app')

@section('content')
<div class="transfer-container">
    <div class="transfer-card">
        {{-- En-tête --}}
        <div class="card-header">
            <div class="header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
            </div>
            <h2 class="card-title">Effectuer un Virement</h2>
            <p class="card-subtitle">Transférez des fonds entre vos comptes en toute sécurité</p>
        </div>

        {{-- Messages d'erreur --}}
        @if ($errors->any())
        <div class="alert alert-error">
            <div class="alert-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="alert-content">
                <h4>Erreur de validation</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        {{-- Formulaire --}}
        <form method="POST" action="{{ route('virements.store') }}" class="transfer-form">
            @csrf

            {{-- Compte Source --}}
            <div class="form-group">
                <label for="compte_source" class="form-label">
                    <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                        <line x1="2" y1="10" x2="22" y2="10"></line>
                    </svg>
                    Compte Source
                </label>
                <div class="select-wrapper">
                    <select name="compte_source" id="compte_source" class="form-select" required>
                        <option value="" disabled selected>Sélectionnez le compte à débiter</option>
                        @foreach($comptes as $c)
                            <option value="{{ $c->id }}" {{ old('compte_source') == $c->id ? 'selected' : '' }}>
                                {{ $c->rib }} — {{ $c->client->nom }} 
                                ({{ number_format($c->solde ?? 0, 2, ',', ' ') }} €)
                            </option>
                        @endforeach
                    </select>
                    <svg class="select-arrow" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
            </div>

            {{-- Flèche de transfert --}}
            <div class="transfer-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <polyline points="19 12 12 19 5 12"></polyline>
                </svg>
            </div>

            {{-- Compte Destination --}}
            <div class="form-group">
                <label for="compte_destination" class="form-label">
                    <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                        <line x1="2" y1="10" x2="22" y2="10"></line>
                    </svg>
                    Compte Destination
                </label>
                <div class="select-wrapper">
                    <select name="compte_destination" id="compte_destination" class="form-select" required>
                        <option value="" disabled selected>Sélectionnez le compte à créditer</option>
                        @foreach($comptes as $c)
                            <option value="{{ $c->id }}" {{ old('compte_destination') == $c->id ? 'selected' : '' }}>
                                {{ $c->rib }} — {{ $c->client->nom }}
                            </option>
                        @endforeach
                    </select>
                    <svg class="select-arrow" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
            </div>

            {{-- Montant --}}
            <div class="form-group">
                <label for="montant" class="form-label">
                    <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                    Montant à Transférer
                </label>
                <div class="input-wrapper">
                    <input 
                        type="number" 
                        step="0.01" 
                        name="montant" 
                        id="montant" 
                        class="form-input" 
                        placeholder="0.00"
                        value="{{ old('montant') }}"
                        min="0.01"
                        required
                    >
                    <span class="input-currency">€</span>
                </div>
                <small class="form-help">Montant minimum : 0,01 €</small>
            </div>

            {{-- Boutons d'action --}}
            <div class="form-actions">
                {{-- Utilisation d'un lien simple au lieu de history.back() pour éviter le JS inline --}}
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Annuler
                </a>
                
                {{-- Bouton Submit direct --}}
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Valider le Virement
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* ===================================
   Variables CSS
   =================================== */
:root {
    --primary-color: #2563eb;
    --primary-hover: #1d4ed8;
    --primary-light: #dbeafe;
    --secondary-color: #64748b;
    --secondary-hover: #475569;
    --success-color: #10b981;
    --success-light: #d1fae5;
    --warning-color: #f59e0b;
    --warning-light: #fef3c7;
    --error-color: #ef4444;
    --error-bg: #fee2e2;
    --border-color: #e2e8f0;
    --text-primary: #0f172a;
    --text-secondary: #64748b;
    --bg-card: #ffffff;
    --bg-body: #f8fafc;
    --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    --radius-sm: 6px;
    --radius-md: 8px;
    --radius-lg: 12px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ===================================
   Conteneur Principal
   =================================== */
.transfer-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 2rem 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.transfer-card {
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-xl);
    max-width: 600px;
    width: 100%;
    overflow: hidden;
    animation: slideUp 0.5s ease-out;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===================================
   En-tête de la Carte
   =================================== */
.card-header {
    background: linear-gradient(135deg, var(--primary-color) 0%, #1e40af 100%);
    padding: 2rem;
    text-align: center;
    color: white;
}

.header-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 64px;
    height: 64px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    margin-bottom: 1rem;
    backdrop-filter: blur(10px);
}

.card-title {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
    letter-spacing: -0.025em;
}

.card-subtitle {
    font-size: 0.95rem;
    opacity: 0.9;
    margin: 0;
    font-weight: 400;
}

/* ===================================
   Alertes
   =================================== */
.alert {
    margin: 1.5rem;
    padding: 1rem 1.25rem;
    border-radius: var(--radius-md);
    display: flex;
    gap: 1rem;
    animation: shake 0.5s;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.alert-error {
    background: var(--error-bg);
    border-left: 4px solid var(--error-color);
}

.alert-icon {
    flex-shrink: 0;
}

.alert-error .alert-icon {
    color: var(--error-color);
}

.alert-content {
    flex: 1;
}

.alert-content h4 {
    margin: 0 0 0.5rem 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--error-color);
}

.alert-content ul {
    margin: 0;
    padding-left: 1.25rem;
    color: #991b1b;
}

.alert-content li {
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

/* ===================================
   Formulaire
   =================================== */
.transfer-form {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.75rem;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.label-icon {
    color: var(--primary-color);
}

/* ===================================
   Champs Select
   =================================== */
.select-wrapper {
    position: relative;
}

.form-select {
    width: 100%;
    padding: 0.875rem 2.5rem 0.875rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    font-size: 0.95rem;
    color: var(--text-primary);
    background: white;
    transition: var(--transition);
    appearance: none;
    cursor: pointer;
}

.form-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px var(--primary-light);
}

.form-select:hover {
    border-color: var(--primary-color);
}

.select-arrow {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: var(--text-secondary);
    transition: var(--transition);
}

.form-select:focus + .select-arrow {
    color: var(--primary-color);
}

/* ===================================
   Champ Input
   =================================== */
.input-wrapper {
    position: relative;
}

.form-input {
    width: 100%;
    padding: 0.875rem 3rem 0.875rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
    background: white;
    transition: var(--transition);
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px var(--primary-light);
}

.form-input:hover {
    border-color: var(--primary-color);
}

.input-currency {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--primary-color);
}

.form-help {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.85rem;
    color: var(--text-secondary);
}

/* ===================================
   Flèche de Transfert
   =================================== */
.transfer-arrow {
    display: flex;
    justify-content: center;
    margin: 1rem 0;
}

.transfer-arrow svg {
    color: var(--primary-color);
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

/* ===================================
   Boutons d'Action
   =================================== */
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    border: none;
    border-radius: var(--radius-md);
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
    box-shadow: var(--shadow-md);
}

.btn-primary:hover {
    background: var(--primary-hover);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-primary:active {
    transform: translateY(0);
}

.btn-secondary {
    background: white;
    color: var(--text-secondary);
    border: 2px solid var(--border-color);
}

.btn-secondary:hover {
    background: var(--bg-body);
    border-color: var(--secondary-color);
    color: var(--text-primary);
}

/* ===================================
   Responsive Design
   =================================== */
@media (max-width: 640px) {
    .transfer-container {
        padding: 1rem;
    }

    .transfer-card {
        border-radius: var(--radius-md);
    }

    .card-header {
        padding: 1.5rem;
    }

    .card-title {
        font-size: 1.5rem;
    }

    .transfer-form {
        padding: 1.5rem;
    }

    .form-actions {
        flex-direction: column-reverse;
    }

    .btn {
        width: 100%;
    }
}

/* ===================================
   Mode Sombre (Optionnel)
   =================================== */
@media (prefers-color-scheme: dark) {
    :root {
        --bg-card: #1e293b;
        --bg-body: #0f172a;
        --text-primary: #f1f5f9;
        --text-secondary: #94a3b8;
        --border-color: #334155;
    }

    .form-select,
    .form-input {
        background: #334155;
        color: var(--text-primary);
    }

    .btn-secondary {
        background: #334155;
        border-color: #475569;
    }
}
</style>
@endsection