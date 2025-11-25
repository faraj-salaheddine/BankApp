@extends('layout.app')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1>Mon Profil Administrateur</h1>
        <p>Gérez vos informations personnelles et la sécurité de votre compte.</p>
    </div>

    <div class="profile-grid">
        
        {{-- COLONNE GAUCHE : Carte de l'Admin --}}
        <div class="profile-card">
            <div class="avatar-section">
                {{-- Utilisation de UI Avatars pour générer une image basée sur le nom --}}
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0f62fe&color=fff&size=128" alt="Avatar" class="avatar-img">
                <h2 class="admin-name">{{ Auth::user()->name }}</h2>
                <span class="admin-role">Super Administrateur</span>
            </div>
            
            <div class="info-list">
                <div class="info-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    <span>Membre depuis : {{ Auth::user()->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="info-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    <span>{{ Auth::user()->email }}</span>
                </div>
            </div>
        </div>

        {{-- COLONNE DROITE : Formulaires de modification --}}
        <div class="profile-content">
            
            {{-- Section 1 : Informations Générales --}}
            <div class="content-card">
                <div class="card-head">
                    <h3>Informations Personnelles</h3>
                </div>
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Nom complet</label>
                            <input type="text" name="name" class="form-input" value="{{ Auth::user()->name }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Adresse Email</label>
                            <input type="email" name="email" class="form-input" value="{{ Auth::user()->email }}">
                        </div>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>

            {{-- Section 2 : Sécurité (Changer MDP) --}}
            <div class="content-card mt-4">
                <div class="card-head">
                    <h3>Sécurité & Mot de passe</h3>
                </div>
                <form action="{{ route('admin.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label class="form-label">Mot de passe actuel</label>
                        <input type="password" name="current_password" class="form-input">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Nouveau mot de passe</label>
                            <input type="password" name="password" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirmer le nouveau</label>
                            <input type="password" name="password_confirmation" class="form-input">
                        </div>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-secondary">Mettre à jour le mot de passe</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<style>
/* =========================================
   VARIABLES & THEME (Style Bancaire Moderne)
   ========================================= */
:root {
    /* Couleurs de base - Slate (Gris bleuté professionnel) */
    --slate-50: #f8fafc;
    --slate-100: #f1f5f9;
    --slate-200: #e2e8f0;
    --slate-400: #94a3b8;
    --slate-600: #475569;
    --slate-800: #1e293b;
    --slate-900: #0f172a;

    /* Couleur Accent (Bleu confiance) */
    --primary: #2563eb;
    --primary-hover: #1d4ed8;
    --primary-light: #eff6ff; /* Fond très clair pour badges */

    /* Interface */
    --radius-lg: 12px;  /* Arrondi des cartes */
    --radius-md: 8px;   /* Arrondi des inputs/boutons */
    --shadow-card: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    --shadow-sticky: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
}

/* =========================================
   LAYOUT GÉNÉRAL
   ========================================= */
.profile-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 2rem;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    color: var(--slate-800);
}

/* En-tête de page */
.profile-header {
    margin-bottom: 2.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--slate-200);
}

.profile-header h1 {
    font-size: 1.875rem;
    font-weight: 700;
    color: var(--slate-900);
    margin: 0 0 0.5rem 0;
    letter-spacing: -0.025em;
}

.profile-header p {
    color: var(--slate-600);
    margin: 0;
    font-size: 1rem;
}

/* =========================================
   GRID SYSTÈME (Gauche / Droite)
   ========================================= */
.profile-grid {
    display: grid;
    grid-template-columns: 320px 1fr; /* Sidebar fixe 320px, le reste flexible */
    gap: 2.5rem;
    align-items: start;
}

/* =========================================
   COLONNE GAUCHE (Carte Identité)
   ========================================= */
.profile-card {
    background: white;
    border-radius: var(--radius-lg);
    border: 1px solid var(--slate-200);
    padding: 2rem;
    text-align: center;
    
    /* Effet Sticky : La carte reste visible au scroll */
    position: sticky;
    top: 2rem; 
    box-shadow: var(--shadow-sticky);
}

.avatar-section {
    margin-bottom: 2rem;
}

.avatar-img {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    margin-bottom: 1rem;
    border: 4px solid var(--primary-light); /* Anneau autour de l'image */
    transition: transform 0.3s ease;
}

.avatar-img:hover {
    transform: scale(1.05); /* Petit zoom au survol */
}

.admin-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--slate-900);
    margin-bottom: 0.5rem;
}

.admin-role {
    display: inline-flex;
    align-items: center;
    background: var(--primary-light);
    color: var(--primary);
    padding: 6px 16px;
    border-radius: 9999px; /* Pill shape */
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Liste d'infos sous l'avatar */
.info-list {
    text-align: left;
    border-top: 1px solid var(--slate-100);
    padding-top: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--slate-600);
    font-size: 0.9rem;
    font-weight: 500;
}

.info-item svg {
    color: var(--slate-400);
}

/* =========================================
   COLONNE DROITE (Contenu & Formulaires)
   ========================================= */
.content-card {
    background: white;
    border-radius: var(--radius-lg);
    border: 1px solid var(--slate-200);
    box-shadow: var(--shadow-card);
    overflow: hidden; /* Pour que le header ne dépasse pas */
    margin-bottom: 2rem;
}

.card-head {
    background: var(--slate-50);
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--slate-200);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.card-head h3 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--slate-800);
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

/* =========================================
   FORMULAIRES & INPUTS
   ========================================= */
form {
    padding: 2rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--slate-700);
    margin-bottom: 0.5rem;
}

.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border-radius: var(--radius-md);
    border: 1px solid var(--slate-200);
    background: #fff;
    color: var(--slate-900);
    font-size: 0.95rem;
    transition: all 0.2s;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--primary-light); /* Ring focus style Stripe */
}

/* Boutons */
.form-footer {
    display: flex;
    justify-content: flex-end;
    padding-top: 1rem;
    border-top: 1px solid var(--slate-50);
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    border: none;
    transition: all 0.2s;
}

.btn-primary {
    background: var(--primary);
    color: white;
    box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
}

.btn-primary:hover {
    background: var(--primary-hover);
    transform: translateY(-1px);
}

.btn-secondary {
    background: white;
    border: 1px solid var(--slate-200);
    color: var(--slate-600);
}

.btn-secondary:hover {
    background: var(--slate-50);
    border-color: var(--slate-400);
    color: var(--slate-800);
}

/* =========================================
   RESPONSIVE (Mobile)
   ========================================= */
@media (max-width: 900px) {
    .profile-grid {
        grid-template-columns: 1fr; /* Une seule colonne */
    }
    
    .profile-card {
        position: static; /* On enlève le sticky sur mobile */
        margin-bottom: 2rem;
    }
    
    .form-row {
        grid-template-columns: 1fr; /* Inputs les uns sous les autres */
    }
    
    .profile-container {
        padding: 1rem;
    }
}
</style>
@endsection