@extends('layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/clients.css') }}">
@endsection

@section('content')

<div class="container mt-4">

    <!-- TOP BAR -->
    <div class="top-bar">
        <h2 class="page-title">Clients</h2>

        <a href="{{ route('clients.create') }}" class="btn-add">+ Ajouter un client</a>
    </div>

    <!-- SEARCH -->
    <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Rechercher un client...">
    </div>

    <!-- TABLE -->
    <div class="card-container mt-3">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>NOM</th>
                    <th>PRÉNOM</th>
                    <th>CIN</th>
                    <th>EMAIL</th>
                    <th>ADRESSE</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($clients as $client)
                    <tr>
                        <td>{{ $client->nom }}</td>
                        <td>{{ $client->prenom }}</td>
                        <td>{{ $client->cin }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->adresse }}</td>

                        <td>
                            <div class="actions">
                                <a class="btn-edit" href="{{ route('clients.edit', $client->id) }}">Modifier</a>

                                <form action="{{ route('clients.destroy', $client->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-delete">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:20px;">
                            Aucun client trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
