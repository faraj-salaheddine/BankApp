<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\DashboardController;

// PAGE D’ACCUEIL = DASHBOARD
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// ROUTES CLIENTS
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
Route::get('/clients/{id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');
Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');

// ROUTES COMPTES
Route::get('/comptes', [CompteController::class, 'index'])->name('comptes.index');
Route::get('/comptes/create', [CompteController::class, 'create'])->name('comptes.create');
Route::post('/comptes', [CompteController::class, 'store'])->name('comptes.store');
Route::get('/comptes/{id}/edit', [CompteController::class, 'edit'])->name('comptes.edit');
Route::put('/comptes/{id}', [CompteController::class, 'update'])->name('comptes.update');
Route::delete('/comptes/{id}', [CompteController::class, 'destroy'])->name('comptes.destroy');
use App\Http\Controllers\VirementController;

Route::get('/virements', [VirementController::class, 'index'])->name('virements.index');
Route::get('/virements/create', [VirementController::class, 'create'])->name('virements.create');
Route::post('/virements', [VirementController::class, 'store'])->name('virements.store');

use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// CORRECTION ICI : Ajout de "\Auth" car ton fichier est dans le dossier Auth
use App\Http\Controllers\Auth\AdminProfileController; 

Route::middleware('auth')->group(function () {
    
    // Afficher la page de profil
    Route::get('/admin/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');

    // Mettre à jour les infos
    Route::put('/admin/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');

    // Mettre à jour le mot de passe
    Route::put('/admin/profile/password', [AdminProfileController::class, 'updatePassword'])->name('admin.password.update');

});
Route::get('/comptes/{id}', [CompteController::class, 'show'])->name('comptes.show');
