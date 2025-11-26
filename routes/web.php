<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTHENTIFICATION
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Auth\LoginController;

// Page Login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| CLIENTS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ClientController;

Route::middleware('auth')->group(function () {

    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');

});


/*
|--------------------------------------------------------------------------
| COMPTES
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\CompteController;

Route::middleware('auth')->group(function () {

    Route::get('/comptes', [CompteController::class, 'index'])->name('comptes.index');
    Route::get('/comptes/create', [CompteController::class, 'create'])->name('comptes.create');
    Route::post('/comptes', [CompteController::class, 'store'])->name('comptes.store');
    Route::get('/comptes/{id}', [CompteController::class, 'show'])->name('comptes.show');
    Route::get('/comptes/{id}/edit', [CompteController::class, 'edit'])->name('comptes.edit');
    Route::put('/comptes/{id}', [CompteController::class, 'update'])->name('comptes.update');
    Route::delete('/comptes/{id}', [CompteController::class, 'destroy'])->name('comptes.destroy');

});


/*
|--------------------------------------------------------------------------
| VIREMENTS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\VirementController;

Route::middleware('auth')->group(function () {

    Route::get('/virements', [VirementController::class, 'index'])->name('virements.index');
    Route::get('/virements/create', [VirementController::class, 'create'])->name('virements.create');
    Route::post('/virements', [VirementController::class, 'store'])->name('virements.store');

});


/*
|--------------------------------------------------------------------------
| PROFIL ADMIN
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Auth\AdminProfileController;

Route::middleware('auth')->group(function () {

    Route::get('/admin/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');

    Route::put('/admin/profile/update', [AdminProfileController::class, 'update'])
        ->name('admin.profile.update');

    Route::put('/admin/profile/password', [AdminProfileController::class, 'updatePassword'])
        ->name('admin.password.update');

});
