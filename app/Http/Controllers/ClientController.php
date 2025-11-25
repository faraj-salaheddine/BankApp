<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Afficher la liste des clients
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    // Formulaire d'ajout d'un client
    public function create()
    {
        return view('clients.create');
    }

    // Enregistrer un nouveau client
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'cin' => 'required|string|max:20|unique:clients',
            'adresse' => 'nullable|string|max:255',
            'email' => 'required|email|unique:clients'
        ]);

        Client::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'cin' => $request->cin,
            'adresse' => $request->adresse,
            'email' => $request->email,
        ]);

        return redirect()->route('clients.index')
            ->with('success', 'Client ajouté avec succès !');
    }

    // Formulaire d'édition
    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    // Modifier un client
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'cin' => 'required|string|max:20|unique:clients,cin,' . $client->id,
            'adresse' => 'nullable|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id
        ]);

        $client->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'cin' => $request->cin,
            'adresse' => $request->adresse,
            'email' => $request->email,
        ]);

        return redirect()->route('clients.index')
            ->with('success', 'Client modifié avec succès !');
    }

    // Supprimer un client
    public function destroy($id)
    {
        Client::destroy($id);

        return redirect()->route('clients.index')
            ->with('success', 'Client supprimé !');
    }
}
