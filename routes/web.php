<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PemilikController;

// =====================
// HALAMAN UTAMA (PUBLIC)
// =====================

// Homepage + Search + Filter
Route::get('/', [KostController::class, 'index'])
    ->name('home');

// List semua kost
Route::get('/kost', [KostController::class, 'index'])
    ->name('kost.index');

// Detail kost
Route::get('/kost/{id}', [KostController::class, 'show'])
    ->name('kost.detail');


// =====================
// DASHBOARD REDIRECT
// =====================

Route::get('/dashboard', function () {
    $user = auth()->user();

    if (!$user) return redirect()->route('login');

    return match ($user->role) {
        'admin'   => redirect()->route('admin.dashboard'),
        'pemilik' => redirect()->route('pemilik.dashboard'),
        default   => redirect()->route('home'),
    };
})->middleware('auth');


// =====================
// PEMILIK
// =====================

Route::prefix('pemilik')
    ->middleware(['auth', 'role:pemilik'])
    ->name('pemilik.')
    ->group(function () {

        Route::get('/dashboard', [PemilikController::class, 'dashboard'])->name('dashboard');
        Route::get('/kost/create', [PemilikController::class, 'create'])->name('kost.create');
        Route::post('/kost', [PemilikController::class, 'store'])->name('kost.store');
        Route::get('/kost/{id}/edit', [PemilikController::class, 'edit'])->name('kost.edit');
        Route::put('/kost/{id}', [PemilikController::class, 'update'])->name('kost.update');
        Route::patch('/kost/{id}/status', [PemilikController::class, 'updateStatus'])->name('kost.status');
    });


// =====================
// ADMIN
// =====================

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/verifikasi', [AdminController::class, 'verifikasiUser'])->name('verifikasi');
        Route::post('/verifikasi/{id}', [AdminController::class, 'approveUser'])->name('verifikasi.approve');
        Route::get('/kost', [AdminController::class, 'kelolaKost'])->name('kost');
        Route::patch('/kost/{id}/status', [AdminController::class, 'updateStatus'])->name('kost.status');
    });

require __DIR__.'/auth.php';
