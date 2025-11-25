@extends('layout.app')

@section('content')
<div class="form-wrapper">
    <div class="form-container">
        {{-- En-tête --}}
        <div class="form-header">
            <a href="{{ url()->previous() }}" class="back-link">
                <i data-lucide="arrow-left" class="icon-xs"></i>
                Retour
            </a>
            
            <h1 class="form-title">
                <i data-lucide="arrow-right-left" class="icon-title"></i>
                Effectuer un Virement
            </h1>
            <p class="form-description">
                Transférez des fonds entre vos comptes en toute sécurité
            </p>
        </div>

        {{-- Messages d'erreur --}}
        @if ($errors->any())
        <div class="alert alert-danger">
            <i data-lucide="alert-circle" class="alert-icon"></i>
            <div class="alert-content">
                <strong>Erreur de validation</strong>
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        {{-- Formulaire --}}
        <form method="POST" action="{{ route('virements.store') }}" class="modern-form horizontal-form">
            @csrf

            {{-- Section des Comptes (Horizontal) --}}
            <div class="accounts-section">
                {{-- Compte Source --}}
                <div class="form-group flex-item">
                    <label for="compte_source" class="form-label">
                        <span class="label-text">
                            <i data-lucide="wallet" class="icon-xs"></i>
                            Compte Source
                        </span>
                        <span class="label-required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <i data-lucide="credit-card" class="input-icon"></i>
                        <select name="compte_source" id="compte_source" class="form-select" required>
                            <option value="" disabled selected>Sélectionnez le compte à débiter</option>
                            @foreach($comptes as $c)
                                <option value="{{ $c->id }}" {{ old('compte_source') == $c->id ? 'selected' : '' }}>
                                    {{ $c->rib }} — {{ $c->client->nom }} 
                                    ({{ number_format($c->solde ?? 0, 2, ',', ' ') }} DH)
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Flèche de transfert (Horizontal) --}}
                <div class="transfer-indicator horizontal">
                    <div class="transfer-icon">
                        <i data-lucide="arrow-right" class="icon-transfer"></i>
                    </div>
                </div>

                {{-- Compte Destination --}}
                <div class="form-group flex-item">
                    <label for="compte_destination" class="form-label">
                        <span class="label-text">
                            <i data-lucide="landmark" class="icon-xs"></i>
                            Compte Destination
                        </span>
                        <span class="label-required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <i data-lucide="credit-card" class="input-icon"></i>
                        <select name="compte_destination" id="compte_destination" class="form-select" required>
                            <option value="" disabled selected>Sélectionnez le compte à créditer</option>
                            @foreach($comptes as $c)
                                <option value="{{ $c->id }}" {{ old('compte_destination') == $c->id ? 'selected' : '' }}>
                                    {{ $c->rib }} — {{ $c->client->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Section Montant et Motif (Horizontal) --}}
            <div class="details-section">
                {{-- Montant --}}
                <div class="form-group flex-item">
                    <label for="montant" class="form-label">
                        <span class="label-text">
                            <i data-lucide="banknote" class="icon-xs"></i>
                            Montant à Transférer
                        </span>
                        <span class="label-required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <i data-lucide="dollar-sign" class="input-icon"></i>
                        <input 
                            type="number" 
                            step="0.01" 
                            name="montant" 
                            id="montant" 
                            class="form-input amount-input" 
                            placeholder="0.00"
                            value="{{ old('montant') }}"
                            min="0.01"
                            required
                        >
                        <span class="input-suffix">DH</span>
                    </div>
                    <small class="form-hint">
                        <i data-lucide="alert-triangle" class="icon-xs"></i>
                        Montant minimum : 0,01 DH
                    </small>
                </div>

                {{-- Motif du Virement --}}
                <div class="form-group flex-item">
                    <label for="motif" class="form-label">
                        <span class="label-text">
                            <i data-lucide="file-text" class="icon-xs"></i>
                            Motif du Virement
                        </span>
                        <span class="label-optional">(Optionnel)</span>
                    </label>
                    <div class="input-wrapper">
                        <i data-lucide="message-square" class="input-icon"></i>
                        <textarea 
                            name="motif" 
                            id="motif" 
                            class="form-textarea" 
                            placeholder="Ex: Remboursement, Loyer, Cadeau..."
                            rows="3"
                        >{{ old('motif') }}</textarea>
                    </div>
                    <small class="form-hint">
                        <i data-lucide="info" class="icon-xs"></i>
                        Ajoutez une description pour faciliter le suivi
                    </small>
                </div>
            </div>

            {{-- Résumé visuel --}}
            <div class="transfer-summary">
                <div class="summary-icon">
                    <i data-lucide="circle-dollar-sign"></i>
                </div>
                <div class="summary-details">
                    <div class="summary-row">
                        <span class="summary-label">Montant du virement</span>
                        <span class="summary-value" id="display-amount">0.00 DH</span>
                    </div>
                    <div class="summary-divider"></div>
                    <div class="summary-row motif-row">
                        <span class="summary-label">
                            <i data-lucide="message-circle" class="icon-xs"></i>
                            Motif
                        </span>
                        <span class="summary-motif" id="display-motif">Aucun motif</span>
                    </div>
                </div>
            </div>

            {{-- Boutons d'action --}}
            <div class="form-actions">
                <a href="{{ url()->previous() }}" class="btn-cancel">
                    <i data-lucide="x"></i>
                    Annuler
                </a>
                
                <button type="submit" class="btn-submit">
                    <i data-lucide="send"></i>
                    Confirmer le Virement
                </button>
            </div>
        </form>
    </div>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

:root {
    --primary: #0066FF;
    --primary-dark: #0052CC;
    --primary-light: #3d8bff;
    --secondary: #00C2FF;
    --success: #00BA88;
    --danger: #FF3B30;
    --warning: #FF9500;
    --dark: #0A1929;
    --gray-50: #F8FAFC;
    --gray-100: #F1F5F9;
    --gray-200: #E2E8F0;
    --gray-300: #CBD5E1;
    --gray-400: #94A3B8;
    --gray-700: #334155;
    --gray-900: #0F172A;
    
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --radius-xl: 24px;
    
    --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.08);
    --shadow-md: 0 4px 12px -2px rgba(0, 0, 0, 0.08);
    --shadow-lg: 0 10px 24px -4px rgba(0, 0, 0, 0.12);
    --shadow-xl: 0 24px 48px -12px rgba(0, 0, 0, 0.18);
    
    --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ============= BASE ============= */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--gray-50);
    color: var(--gray-900);
    line-height: 1.6;
    min-height: 100vh;
    padding: 20px 0;
}

/* ============= FORM WRAPPER ============= */
.form-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-container {
    background: white;
    border-radius: var(--radius-xl);
    padding: 44px;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--gray-200);
}

/* ============= FORM HEADER ============= */
.form-header {
    margin-bottom: 36px;
    padding-bottom: 24px;
    border-bottom: 2px solid var(--gray-100);
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--gray-700);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 20px;
    transition: var(--transition);
    padding: 6px 12px;
    border-radius: var(--radius-sm);
}

.back-link:hover {
    color: var(--primary);
    background: var(--gray-50);
    gap: 8px;
}

.form-title {
    font-size: 30px;
    font-weight: 800;
    color: var(--dark);
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 10px;
    letter-spacing: -0.5px;
}

.form-description {
    color: var(--gray-700);
    font-size: 15px;
    margin: 0;
    line-height: 1.5;
}

/* ============= ALERTS ============= */
.alert {
    padding: 18px 20px;
    border-radius: var(--radius-md);
    margin-bottom: 28px;
    display: flex;
    gap: 14px;
    animation: slideDown 0.4s ease;
}

.alert-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #7f1d1d;
    border-left: 4px solid var(--danger);
    box-shadow: var(--shadow-sm);
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-icon {
    flex-shrink: 0;
    width: 24px;
    height: 24px;
    color: var(--danger);
}

.alert-content strong {
    display: block;
    margin-bottom: 10px;
    font-weight: 700;
    font-size: 15px;
}

.error-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.error-list li {
    padding-left: 24px;
    position: relative;
    margin-bottom: 6px;
    font-size: 14px;
    line-height: 1.5;
}

.error-list li::before {
    content: "→";
    position: absolute;
    left: 6px;
    font-weight: 700;
}

/* ============= HORIZONTAL FORM LAYOUT ============= */
.horizontal-form .accounts-section,
.horizontal-form .details-section {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 24px;
    align-items: start;
    margin-bottom: 32px;
}

.horizontal-form .details-section {
    grid-template-columns: 1fr 1fr;
}

.flex-item {
    flex: 1;
    min-width: 0;
}

/* ============= FORM GROUPS ============= */
.modern-form .form-group {
    margin-bottom: 0;
}

.form-label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    font-weight: 600;
    color: var(--dark);
    font-size: 14px;
}

.label-text {
    display: flex;
    align-items: center;
    gap: 8px;
}

.label-required {
    color: var(--danger);
    font-weight: 700;
}

.label-optional {
    color: var(--gray-400);
    font-weight: 500;
    font-size: 13px;
}

/* ============= INPUT WRAPPER ============= */
.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon {
    position: absolute;
    left: 16px;
    width: 20px;
    height: 20px;
    color: var(--gray-400);
    pointer-events: none;
    z-index: 1;
    transition: var(--transition);
}

.form-input, .form-select, .form-textarea {
    width: 100%;
    padding: 14px 16px 14px 48px;
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-md);
    font-size: 15px;
    font-family: 'Inter', sans-serif;
    transition: var(--transition);
    background: var(--gray-50);
    color: var(--dark);
}

.form-textarea {
    resize: vertical;
    min-height: 120px;
    line-height: 1.6;
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: var(--primary);
    background: white;
    box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.08);
}

.form-input:hover, .form-select:hover, .form-textarea:hover {
    border-color: var(--gray-300);
}

.form-input:focus ~ .input-icon,
.form-select:focus ~ .input-icon,
.form-textarea:focus ~ .input-icon {
    color: var(--primary);
}

.amount-input {
    font-weight: 700;
    font-size: 20px;
    padding-right: 70px;
    letter-spacing: -0.3px;
}

.input-suffix {
    position: absolute;
    right: 18px;
    color: var(--primary);
    font-weight: 800;
    font-size: 18px;
    pointer-events: none;
}

.form-hint {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 8px;
    font-size: 13px;
    color: var(--gray-700);
    line-height: 1.4;
}

/* ============= TRANSFER INDICATOR (HORIZONTAL) ============= */
.transfer-indicator.horizontal {
    display: flex;
    align-items: center;
    justify-content: center;
    align-self: center;
    margin-top: 28px;
}

.transfer-icon {
    width: 52px;
    height: 52px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 6px 20px rgba(0, 102, 255, 0.35);
    animation: pulse 2.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.icon-transfer {
    width: 26px;
    height: 26px;
    color: white;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 6px 20px rgba(0, 102, 255, 0.35);
    }
    50% {
        transform: scale(1.08);
        box-shadow: 0 10px 28px rgba(0, 102, 255, 0.5);
    }
}

/* ============= TRANSFER SUMMARY ============= */
.transfer-summary {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    padding: 28px 32px;
    border-radius: var(--radius-lg);
    margin: 36px 0;
    border: 2px solid #bae6fd;
    box-shadow: var(--shadow-md);
    display: flex;
    gap: 24px;
    align-items: flex-start;
}

.summary-icon {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 6px 16px rgba(0, 102, 255, 0.3);
}

.summary-icon i {
    width: 32px;
    height: 32px;
    color: white;
}

.summary-details {
    flex: 1;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
}

.summary-row.motif-row {
    align-items: flex-start;
}

.summary-divider {
    height: 2px;
    background: linear-gradient(90deg, transparent, #93c5fd, transparent);
    margin: 10px 0;
}

.summary-label {
    font-size: 15px;
    color: var(--gray-700);
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 6px;
}

.summary-value {
    font-size: 28px;
    font-weight: 800;
    color: var(--primary);
    letter-spacing: -0.5px;
}

.summary-motif {
    font-size: 14px;
    color: var(--gray-700);
    font-weight: 500;
    font-style: italic;
    text-align: right;
    max-width: 500px;
    line-height: 1.6;
}

.summary-motif.empty {
    color: var(--gray-400);
}

/* ============= FORM ACTIONS ============= */
.form-actions {
    display: flex;
    gap: 16px;
    margin-top: 40px;
    justify-content: flex-end;
}

.btn-submit {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    padding: 16px 36px;
    border: none;
    border-radius: var(--radius-md);
    font-weight: 700;
    font-size: 15px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: var(--transition);
    font-family: 'Inter', sans-serif;
    box-shadow: 0 4px 16px rgba(0, 102, 255, 0.3);
    letter-spacing: -0.2px;
}

.btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 102, 255, 0.4);
}

.btn-submit:active {
    transform: translateY(-1px);
}

.btn-cancel {
    padding: 16px 28px;
    background: white;
    color: var(--gray-700);
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-md);
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: var(--transition);
    font-family: 'Inter', sans-serif;
}

.btn-cancel:hover {
    background: var(--gray-50);
    border-color: var(--gray-300);
}

/* ============= ICONS ============= */
.icon-xs {
    width: 16px;
    height: 16px;
    display: inline-block;
    vertical-align: middle;
}

.icon-title {
    width: 32px;
    height: 32px;
    stroke-width: 2.5;
}

[data-lucide] {
    stroke-width: 2;
}

/* ============= RESPONSIVE ============= */
@media (max-width: 1024px) {
    .horizontal-form .accounts-section,
    .horizontal-form .details-section {
        grid-template-columns: 1fr;
        gap: 28px;
    }
    
    .transfer-indicator.horizontal {
        margin-top: 0;
        margin-bottom: 0;
        transform: rotate(90deg);
    }
    
    .icon-transfer {
        transform: rotate(-90deg);
    }
}

@media (max-width: 768px) {
    .form-wrapper {
        padding: 0 16px;
    }
    
    .form-container {
        padding: 32px 24px;
        border-radius: var(--radius-lg);
    }
    
    .form-title {
        font-size: 24px;
        gap: 10px;
    }
    
    .form-actions {
        flex-direction: column-reverse;
        gap: 12px;
    }
    
    .btn-submit,
    .btn-cancel {
        width: 100%;
        justify-content: center;
    }
    
    .transfer-summary {
        flex-direction: column;
        gap: 16px;
        padding: 24px;
    }
    
    .summary-icon {
        margin: 0 auto;
    }
    
    .summary-motif {
        max-width: 100%;
    }
    
    .summary-value {
        font-size: 24px;
    }
}

@media (max-width: 480px) {
    .form-container {
        padding: 24px 20px;
    }
    
    .amount-input {
        font-size: 18px;
    }
    
    .summary-value {
        font-size: 20px;
    }
}
</style>

<script>
// Mise à jour dynamique du résumé
document.addEventListener('DOMContentLoaded', function() {
    const montantInput = document.getElementById('montant');
    const motifInput = document.getElementById('motif');
    const displayAmount = document.getElementById('display-amount');
    const displayMotif = document.getElementById('display-motif');
    
    // Mise à jour du montant
    if (montantInput) {
        montantInput.addEventListener('input', function() {
            const value = parseFloat(this.value) || 0;
            const formatted = new Intl.NumberFormat('fr-MA', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(value);
            
            displayAmount.textContent = formatted + ' DH';
        });
    }
    
    // Mise à jour du motif en temps réel
    if (motifInput) {
        motifInput.addEventListener('input', function() {
            const motifText = this.value.trim();
            
            if (motifText) {
                displayMotif.textContent = motifText;
                displayMotif.classList.remove('empty');
            } else {
                displayMotif.textContent = 'Aucun motif';
                displayMotif.classList.add('empty');
            }
        });
    }
});
</script>
@endsection