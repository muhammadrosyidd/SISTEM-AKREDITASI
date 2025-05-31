<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\Kriteria2Controller;
use App\Http\Controllers\Kriteria3Controller;
use App\Http\Controllers\Kriteria4Controller;
use App\Http\Controllers\Kriteria5Controller;
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

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

    Route::middleware(['authorize:A1'])->group(function () {
    Route::get('/kriteria1', [KriteriaController::class, 'index'])->name('kriteria1.index');
    Route::get('/kriteria2', [KriteriaController::class, 'index'])->name('kriteria2.index');
    Route::get('/kriteria3', [KriteriaController::class, 'index'])->name('kriteria3.index');
    Route::get('/kriteria4', [KriteriaController::class, 'index'])->name('kriteria4.index');
    Route::get('/kriteria5', [KriteriaController::class, 'index'])->name('kriteria5.index');
});



    // Kriteria 1 (HANYA UNTUK A1)
    Route::middleware(['authorize:A1'])->group(function () {
        Route::get('/kriteria1/input', [KriteriaController::class, 'create'])->name('kriteria.1.input');
        Route::get('/kriteria1', [KriteriaController::class, 'index'])->name('kriteria.index');
        Route::post('/kriteria1', [KriteriaController::class, 'store'])->name('kriteria1.store');
        Route::post('/kriteria1/list', [KriteriaController::class, 'list'])->name('kriteria.1.list');
        Route::get('/kriteria1/{id}/show', [KriteriaController::class, 'preview'])->name('kriteria.detail');
        Route::get('/kriteria1/{id}/preview-pdf', [KriteriaController::class, 'previewpdf'])->name('kriteria1.preview-pdf');
        Route::get('/kriteria1/{id}/edit', [KriteriaController::class, 'edit'])->name('kriteria1.edit');
        Route::put('/kriteria1/{id}', [KriteriaController::class, 'update'])->name('kriteria1.update');
        Route::delete('/kriteria1/{id}', [KriteriaController::class, 'destroy'])->name('kriteria1.destroy');
    });

    
    // Kriteria 2 (HANYA UNTUK A2)
    Route::middleware(['authorize:A2'])->group(function () {
        Route::get('/kriteria2/input', [Kriteria2Controller::class, 'create'])->name('kriteria.2.input');
        Route::get('/kriteria2', [Kriteria2Controller::class, 'index'])->name('kriteria2.index');
        Route::post('/kriteria2', [Kriteria2Controller::class, 'store'])->name('kriteria2.store');
        Route::post('/kriteria2/list', [Kriteria2Controller::class, 'list'])->name('kriteria.2.list');
        Route::get('/kriteria2/{id}/show', [Kriteria2Controller::class, 'preview'])->name('kriteria2.detail');
        Route::get('/kriteria2/{id}/preview-pdf', [Kriteria2Controller::class, 'previewpdf'])->name('kriteria2.preview-pdf');
        Route::get('/kriteria2/{id}/edit', [Kriteria2Controller::class, 'edit'])->name('kriteria2.edit');
        Route::put('/kriteria2/{id}', [Kriteria2Controller::class, 'update'])->name('kriteria2.update');
        Route::delete('/kriteria2/{id}', [Kriteria2Controller::class, 'destroy'])->name('kriteria2.destroy');
    });

     // Kriteria 3 (HANYA UNTUK A3)
    Route::middleware(['authorize:A3'])->group(function () {
        Route::get('/kriteria3/input', [Kriteria3Controller::class, 'create'])->name('kriteria.3.input');
        Route::get('/kriteria3', [Kriteria3Controller::class, 'index'])->name('kriteria3.index');
        Route::post('/kriteria3', [Kriteria3Controller::class, 'store'])->name('kriteria3.store');
        Route::post('/kriteria3/list', [Kriteria3Controller::class, 'list'])->name('kriteria.3.list');
        Route::get('/kriteria3/{id}/show', [Kriteria3Controller::class, 'preview'])->name('kriteria3.detail');
        Route::get('/kriteria3/{id}/preview-pdf', [Kriteria3Controller::class, 'previewpdf'])->name('kriteria3.preview-pdf');
        Route::get('/kriteria3/{id}/edit', [Kriteria3Controller::class, 'edit'])->name('kriteria3.edit');
        Route::put('/kriteria3/{id}', [Kriteria3Controller::class, 'update'])->name('kriteria3.update');
        Route::delete('/kriteria3/{id}', [Kriteria3Controller::class, 'destroy'])->name('kriteria3.destroy');
    });

     // Kriteria 4 (HANYA UNTUK A4)
    Route::middleware(['authorize:A4'])->group(function () {
        Route::get('/kriteria4/input', [Kriteria4Controller::class, 'create'])->name('kriteria.4.input');
        Route::get('/kriteria4', [Kriteria4Controller::class, 'index'])->name('kriteria4.index');
        Route::post('/kriteria4', [Kriteria4Controller::class, 'store'])->name('kriteria4.store');
        Route::post('/kriteria4/list', [Kriteria4Controller::class, 'list'])->name('kriteria.4.list');
        Route::get('/kriteria4/{id}/show', [Kriteria4Controller::class, 'preview'])->name('kriteria4.detail');
        Route::get('/kriteria4/{id}/preview-pdf', [Kriteria4Controller::class, 'previewpdf'])->name('kriteria4.preview-pdf');
        Route::get('/kriteria4/{id}/edit', [Kriteria4Controller::class, 'edit'])->name('kriteria4.edit');
        Route::put('/kriteria4/{id}', [Kriteria4Controller::class, 'update'])->name('kriteria4.update');
        Route::delete('/kriteria4/{id}', [Kriteria4Controller::class, 'destroy'])->name('kriteria4.destroy');
    });


     // Kriteria 5 (HANYA UNTUK A5)
    Route::middleware(['authorize:A5'])->group(function () {
        Route::get('/kriteria5/input', [Kriteria5Controller::class, 'create'])->name('kriteria.5.input');
        Route::get('/kriteria5', [Kriteria5Controller::class, 'index'])->name('kriteria5.index');
        Route::post('/kriteria5', [Kriteria5Controller::class, 'store'])->name('kriteria5.store');
        Route::post('/kriteria5/list', [Kriteria5Controller::class, 'list'])->name('kriteria.5.list');
        Route::get('/kriteria5/{id}/show', [Kriteria5Controller::class, 'preview'])->name('kriteria5.detail');
        Route::get('/kriteria5/{id}/preview-pdf', [Kriteria5Controller::class, 'previewpdf'])->name('kriteria5.preview-pdf');
        Route::get('/kriteria5/{id}/edit', [Kriteria5Controller::class, 'edit'])->name('kriteria5.edit');
        Route::put('/kriteria5/{id}', [Kriteria5Controller::class, 'update'])->name('kriteria5.update');
        Route::delete('/kriteria5/{id}', [Kriteria5Controller::class, 'destroy'])->name('kriteria5.destroy');
    });

    // Validasi (HANYA UNTUK KJR)
    Route::get('/validasi', [ValidasiController::class, 'index'])->name('validasi.index')->middleware('authorize:KJR');
});
