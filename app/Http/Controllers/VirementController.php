<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Virement;
use Illuminate\Http\Request;

class VirementController extends Controller
{
    public function index()
    {
        $virements = Virement::with(['source', 'destination'])->get();
        return view('virements.index', compact('virements'));
    }

    public function create()
    {
        $comptes = Compte::all();
        return view('virements.create', compact('comptes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'compte_source' => 'required|different:compte_destination',
            'compte_destination' => 'required',
            'montant' => 'required|numeric|min:1',
            'motif' => 'nullable|string|max:255'
        ]);

        $source = Compte::find($request->compte_source);
        $destination = Compte::find($request->compte_destination);

        // Vérification du solde
        if ($source->solde < $request->montant) {
            return back()->withErrors(['montant' => 'Solde insuffisant !']);
        }

        // Débit
        $source->solde -= $request->montant;
        $source->save();

        // Crédit
        $destination->solde += $request->montant;
        $destination->save();

        // Enregistrer le virement
        Virement::create([
            'compte_source' => $source->id,
            'compte_destination' => $destination->id,
            'montant' => $request->montant,
            'motif' => $request->motif
        ]);

        return redirect()->route('virements.index')->with('success', 'Virement effectué !');
    }
}

