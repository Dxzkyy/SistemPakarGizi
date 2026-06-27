<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Routes Admin (Pakar)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Gejala
    Route::resource('gejala', App\Http\Controllers\Admin\GejalaController::class);

    // Manajemen Hipotesis
    Route::resource('hipotesis', App\Http\Controllers\Admin\HipotesisController::class);

    // Konsultasi Pakar
    Route::get('/konsultasi', [App\Http\Controllers\Admin\KonsultasiController::class, 'index'])->name('konsultasi.index');
    Route::get('/konsultasi/{id}', [App\Http\Controllers\Admin\KonsultasiController::class, 'show'])->name('konsultasi.show');
    Route::post('/konsultasi/{id}/validasi', [App\Http\Controllers\Admin\KonsultasiController::class, 'validasi'])->name('konsultasi.validasi');
});

// Routes User (Ibu Hamil)
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');

    // Self Diagnostik
    Route::get('/diagnostik', [App\Http\Controllers\User\DiagnostikController::class, 'index'])->name('diagnostik.index');
    Route::post('/diagnostik', [App\Http\Controllers\User\DiagnostikController::class, 'proses'])->name('diagnostik.proses');
    Route::get('/diagnostik/hasil/{id}', [App\Http\Controllers\User\DiagnostikController::class, 'hasil'])->name('diagnostik.hasil');

    // Riwayat
    Route::get('/riwayat', [App\Http\Controllers\User\RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{id}', [App\Http\Controllers\User\RiwayatController::class, 'show'])->name('riwayat.show');

    // Profil
    Route::get('/profil', [App\Http\Controllers\User\ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [App\Http\Controllers\User\ProfilController::class, 'update'])->name('profil.update');
});

require __DIR__.'/auth.php';