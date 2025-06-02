<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Halaman utama
Route::get('/', function () {
    return view('index');
});

// LOGIN & LOGOUT
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postlogin'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ROUTE TERPROTEKSI (HANYA UNTUK USER YANG SUDAH LOGIN)
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kriteria 1 (HANYA UNTUK ROLE A1, kecuali preview PDF)
    Route::middleware(['authorize:A1'])->group(function () {
        Route::get('/kriteria1/input', [KriteriaController::class, 'create'])->name('kriteria.1.input');
        Route::get('/kriteria1', [KriteriaController::class, 'index'])->name('kriteria.index');
        Route::post('/kriteria1', [KriteriaController::class, 'store'])->name('kriteria1.store');
        Route::post('/kriteria1/list', [KriteriaController::class, 'list'])->name('kriteria.1.list');
        Route::get('/kriteria1/{id}/show', [KriteriaController::class, 'preview'])->name('kriteria.detail');
        Route::get('/kriteria1/{id}/edit', [KriteriaController::class, 'edit'])->name('kriteria1.edit');
        Route::put('/kriteria1/{id}', [KriteriaController::class, 'update'])->name('kriteria1.update');
        Route::delete('/kriteria1/{id}', [KriteriaController::class, 'destroy'])->name('kriteria1.destroy');
    });

    // Route untuk preview PDF Kriteria 1, dapat diakses oleh A1 dan KJR
    Route::get('/kriteria1/{id}/preview-pdf', [KriteriaController::class, 'previewpdf'])
        ->middleware(['authorize:A1,KJR'])
        ->name('kriteria1.preview-pdf');

    // Kriteria 2 (HANYA UNTUK ROLE A2)
    Route::middleware(['authorize:A2'])->group(function () {
        Route::get('/kriteria2', [KriteriaController::class, 'kriteria2'])->name('kriteria.2');
    });

    // Validasi (HANYA UNTUK ROLE KJR)
    Route::middleware(['authorize:KJR'])->group(function () {
        Route::get('/validasi', [ValidasiController::class, 'index'])->name('validasi.index');
        Route::get('/validasi/list', [ValidasiController::class, 'list'])->name('validasi.list');
        Route::post('/validasi/submit', [ValidasiController::class, 'validateDocument'])->name('validasi.submit');
        Route::get('/validasi/{id}/detail-modal', [ValidasiController::class, 'modalDetail'])->name('validasi.modal.detail');
    });
});