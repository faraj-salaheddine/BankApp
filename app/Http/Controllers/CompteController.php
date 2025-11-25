<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Client;
use Illuminate\Http\Request;

class CompteController extends Controller
{
    // 1. Liste des comptes
    public function index()
    {
        $comptes = Compte::with('client')->get();
        return view('comptes.index', compact('comptes'));
    }

    // 2. Formulaire d'ajout
    public function create()
    {
        $clients = Client::all();
        return view('comptes.create', compact('clients'));
    }

    // 3. Enregistrement
    public function store(Request $request)
    {
        $request->validate([
            'rib' => 'required|unique:comptes',
            'solde' => 'required|numeric',
            'client_id' => 'required|exists:clients,id',
        ]);

        Compte::create($request->all());

        return redirect()->route('comptes.index')->with('success', 'Compte ajouté avec succès !');
    }

    // 4. Formulaire modification
    public function edit($id)
    {
        $compte = Compte::findOrFail($id);
        $clients = Client::all();
        return view('comptes.edit', compact('compte', 'clients'));
    }

    // 5. Mise à jour
    public function update(Request $request, $id)
    {
        $compte = Compte::findOrFail($id);

        $request->validate([
            'rib' => 'required|unique:comptes,rib,'.$compte->id,
            'solde' => 'required|numeric',
            'client_id' => 'required|exists:clients,id',
        ]);

        $compte->update($request->all());

        return redirect()->route('comptes.index')->with('success', 'Compte modifié avec succès !');
    }

    // 6. Suppression
    public function destroy($id)
    {
        Compte::destroy($id);
        return redirect()->route('comptes.index')->with('success', 'Compte supprimé !');
    }
  public function show($id)
{
    $compte = Compte::with('client')->findOrFail($id);
    return view('comptes.show', compact('compte'));
}


}
