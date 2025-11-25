<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Compte;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients = Client::count();
        $totalComptes = Compte::count();
        $totalSolde = Compte::sum('solde');
        $dernierClient = Client::latest()->first();
        $derniersComptes = Compte::with('client')->latest()->take(5)->get();

        // Exemple de données pour Chart.js
        $labels = ["Jan", "Fév", "Mar", "Avr", "Mai", "Jun"];
        $data = [1200, 2300, 1800, 2900, 3100, 4000];

        return view('dashboard', compact(
            'totalClients',
            'totalComptes',
            'totalSolde',
            'dernierClient',
            'derniersComptes',
            'labels',
            'data'
        ));
    }
}
