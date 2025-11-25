@extends('layout.app')

@section('content')
<div class="page-container">
    
    {{-- En-tête de la page --}}
    <div class="page-header">
        <div class="header-content">
            <h1>Historique des Virements</h1>
            <p>Consultez l'ensemble des transactions effectuées.</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('virements.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Nouveau Virement
            </a>
        </div>
    </div>

    {{-- Carte du Tableau --}}
    <div class="table-card">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th width="30%">Compte Source</th>
                        <th width="5%" class="text-center">
                            </th>
                        <th width="30%">Compte Destination</th>
                        <th width="20%" class="text-right">Montant</th>
                        <th width="15%" class="text-right">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($virements as $v)
                    <tr>
                        {{-- Source --}}
                        <td>
                            <div class="account-info">
                                <div class="icon-box debit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 9V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path><path d="M12 2v20"></path><path d="m17 5 4 4-4 4"></path></svg>
                                </div>
                                <div>
                                    <span class="rib">{{ $v->source->rib }}</span>
                                    {{-- On vérifie si la relation client existe --}}
                                    @if(isset($v->source->client))
                                        <small class="client-name">{{ $v->source->client->nom }} {{ $v->source->client->prenom }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Flèche --}}
                        <td class="text-center">
                            <svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </td>

                        {{-- Destination --}}
                        <td>
                            <div class="account-info">
                                <div class="icon-box credit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 9V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path><path d="m19 15-4-4 4-4"></path><path d="M22 2v20"></path></svg>
                                </div>
                                <div>
                                    <span class="rib">{{ $v->destination->rib }}</span>
                                    @if(isset($v->destination->client))
                                        <small class="client-name">{{ $v->destination->client->nom }} {{ $v->destination->client->prenom }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Montant --}}
                        <td class="text-right">
                            <span class="amount-badge">
                                - {{ number_format($v->montant, 2, ',', ' ') }} DH
                            </span>
                        </td>

                        {{-- Date --}}
                        <td class="text-right">
                            <div class="date-info">
                                <span class="date-day">{{ $v->created_at->format('d M Y') }}</span>
                                <small class="date-time">{{ $v->created_at->format('H:i') }}</small>
                            </div>
                        </td>
                    </tr>
                    @empty
                    {{-- État vide (Si aucun virement) --}}
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-icon">📭</div>
                                <h3>Aucun virement effectué</h3>
                                <p>Les transactions apparaîtront ici une fois effectuées.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination (Si tu utilises paginate() dans le contrôleur) --}}
        @if(method_exists($virements, 'links'))
        <div class="pagination-container">
            {{ $virements->links() }}
        </div>
        @endif
    </div>
</div>

<style>
/* =========================================
   VARIABLES & THEME (Cohérent avec le profil)
   ========================================= */
:root {
    --slate-50: #f8fafc;
    --slate-100: #f1f5f9;
    --slate-200: #e2e8f0;
    --slate-400: #94a3b8;
    --slate-500: #64748b;
    --slate-800: #1e293b;
    --slate-900: #0f172a;
    --primary: #2563eb;
    --primary-hover: #1d4ed8;
    --success-bg: #dcfce7;
    --success-text: #166534;
}

/* =========================================
   LAYOUT
   ========================================= */
.page-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    font-family: 'Inter', system-ui, sans-serif;
}

/* Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.page-header h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--slate-900);
    margin: 0 0 0.5rem 0;
}

.page-header p {
    color: var(--slate-500);
    margin: 0;
}

/* Bouton Nouveau */
.btn-primary {
    background: var(--primary);
    color: white;
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
    box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
}
.btn-primary:hover {
    background: var(--primary-hover);
    transform: translateY(-1px);
}

/* =========================================
   TABLE CARD
   ========================================= */
.table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    border: 1px solid var(--slate-200);
    overflow: hidden;
}

.table-responsive {
    width: 100%;
    overflow-x: auto;
}

.custom-table {
    width: 100%;
    border-collapse: collapse;
    white-space: nowrap;
}

/* En-têtes */
.custom-table thead th {
    background: var(--slate-50);
    padding: 1rem 1.5rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--slate-500);
    letter-spacing: 0.05em;
    border-bottom: 1px solid var(--slate-200);
}

.custom-table .text-right { text-align: right; }
.custom-table .text-center { text-align: center; }

/* Lignes */
.custom-table tbody tr {
    border-bottom: 1px solid var(--slate-100);
    transition: background 0.1s;
}

.custom-table tbody tr:last-child {
    border-bottom: none;
}

.custom-table tbody tr:hover {
    background: var(--slate-50);
}

.custom-table td {
    padding: 1rem 1.5rem;
    vertical-align: middle;
    color: var(--slate-800);
}

/* =========================================
   COMPOSANTS CELLULES
   ========================================= */
/* Infos Compte */
.account-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.icon-box {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.icon-box.debit { background: #fee2e2; color: #ef4444; }
.icon-box.credit { background: #dcfce7; color: #16a34a; }

.rib {
    display: block;
    font-family: 'Monaco', 'Consolas', monospace;
    font-weight: 600;
    font-size: 0.95rem;
    color: var(--slate-900);
}

.client-name {
    display: block;
    color: var(--slate-500);
    font-size: 0.85rem;
}

/* Flèche centrale */
.arrow-icon {
    color: var(--slate-400);
}

/* Badge Montant */
.amount-badge {
    font-weight: 700;
    font-size: 1rem;
    color: var(--slate-900);
}

/* Date */
.date-info {
    display: flex;
    flex-direction: column;
}
.date-day { font-weight: 500; font-size: 0.9rem; }
.date-time { color: var(--slate-400); font-size: 0.8rem; }

/* =========================================
   ÉTAT VIDE
   ========================================= */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--slate-500);
}
.empty-icon { font-size: 3rem; margin-bottom: 1rem; }
.empty-state h3 { color: var(--slate-800); margin-bottom: 0.5rem; }

/* Pagination */
.pagination-container {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--slate-200);
}

/* Responsive */
@media (max-width: 768px) {
    .page-header { flex-direction: column; align-items: flex-start; }
    .btn-primary { width: 100%; justify-content: center; }
}
</style>
@endsection