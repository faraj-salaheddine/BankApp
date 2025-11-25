@extends('layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/clients.css') }}">
@endsection

@section('content')
<h2 class="page-title">Liste des clients</h2>

<a href="{{ route('clients.create') }}" class="btn-main">Ajouter un client</a>

<div class="card-container">
    <table class="table-custom">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->nom }}</td>
                    <td>{{ $client->prenom }}</td>
                    <td>{{ $client->email }}</td>
                    <td class="actions">
                        <a href="{{ route('clients.edit', $client->id) }}" class="btn-edit">Modifier</a>

                        <form method="POST" action="{{ route('clients.destroy', $client->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn-delete" onclick="return confirm('Supprimer ce client ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>
@endsection
