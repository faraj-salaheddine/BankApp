@extends('layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/compte.css') }}">
@endsection

@section('content')

<div class="container comptes-container">

    <h1 class="page-title">Liste des comptes</h1>

    <a href="{{ route('comptes.create') }}" class="btn-main mb-3">Ajouter un compte</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card-container">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>RIB</th>
                    <th>Solde</th>
                    <th>Client</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($comptes as $compte)
                <tr>
                    <td>{{ $compte->id }}</td>
                    <td>{{ $compte->rib }}</td>
                    <td>{{ number_format($compte->solde, 2) }} DH</td>
                    <td>{{ $compte->client->nom }} {{ $compte->client->prenom }}</td>

                    <td class="actions">
                        <a href="{{ route('comptes.edit', $compte->id) }}" class="btn-edit">Modifier</a>

                        <form action="{{ route('comptes.destroy', $compte->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button class="btn-delete" onclick="return confirm('Supprimer ce compte ?')">
                                Supprimer
                            </button>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>

@endsection
