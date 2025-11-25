@extends('layout.app')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@section('content')

<!-- TITRE -->
<div class="dashboard-header">
    <h2>Bienvenue dans votre agence bancaire</h2>
    <input type="text" placeholder="Recherche..." class="search-input">
</div>

<!-- STAT CARDS -->
<div class="cards-grid">

    <div class="card">
        <h4>Total des clients</h4>
        <p class="value">{{ $totalClients }}</p>
    </div>

    <div class="card">
        <h4>Total des comptes</h4>
        <p class="value">{{ $totalComptes }}</p>
    </div>

    <div class="card">
        <h4>Solde global de la banque</h4>
        <p class="value">{{ number_format($totalSolde, 2) }} DH</p>
    </div>

    <div class="card">
        <h4>Dernier client ajouté</h4>
        <p class="value">
            @if($dernierClient)
                {{ $dernierClient->nom }} {{ $dernierClient->prenom }}
            @else
                Aucun
            @endif
        </p>
    </div>

</div>

<!-- Derniers comptes -->
<div class="section">
    <h3>Derniers comptes créés</h3>

    <table class="modern-table">
        <thead>
            <tr>
                <th>RIB</th>
                <th>Solde</th>
                <th>Client</th>
            </tr>
        </thead>

        <tbody>
            @foreach($derniersComptes as $c)
            <tr>
                <td>{{ $c->rib }}</td>
                <td>{{ $c->solde }} DH</td>
                <td>{{ $c->client->nom }} {{ $c->client->prenom }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Données envoyées au JS -->
<input type="hidden" id="labels-data" value='@json($labels)'>
<input type="hidden" id="solde-data" value='@json($data)'>

<!-- GRAPHIQUE -->
<div class="section">
    <h3>Statistique : Solde total par mois</h3>
    <canvas id="chartSolde" height="120"></canvas>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Fichier JS -->
<script src="{{ asset('js/chart-solde.js') }}"></script>

@endsection
