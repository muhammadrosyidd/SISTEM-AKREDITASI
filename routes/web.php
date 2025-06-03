<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Kriteria2Controller;
use App\Http\Controllers\Kriteria3Controller;
use App\Http\Controllers\Kriteria4Controller;
use App\Http\Controllers\Kriteria5Controller;
use App\Http\Controllers\Kriteria6Controller;
use App\Http\Controllers\Kriteria7Controller;
use App\Http\Controllers\Kriteria8Controller;
use App\Http\Controllers\Kriteria9Controller;
use App\Http\Controllers\ValidasiDirController;

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

     Route::middleware(['authorize:A6'])->group(function () {
        Route::get('/kriteria6/input', [Kriteria6Controller::class, 'create'])->name('kriteria.6.input');
        Route::get('/kriteria6', [Kriteria6Controller::class, 'index'])->name('kriteria6.index');
        Route::post('/kriteria6', [Kriteria6Controller::class, 'store'])->name('kriteria6.store');
        Route::post('/kriteria6/list', [Kriteria6Controller::class, 'list'])->name('kriteria.6.list');
        Route::get('/kriteria6/{id}/show', [Kriteria6Controller::class, 'preview'])->name('kriteria6.detail');
        Route::get('/kriteria6/{id}/preview-pdf', [Kriteria6Controller::class, 'previewpdf'])->name('kriteria6.preview-pdf');
        Route::get('/kriteria6/{id}/edit', [Kriteria6Controller::class, 'edit'])->name('kriteria6.edit');
        Route::put('/kriteria6/{id}', [Kriteria6Controller::class, 'update'])->name('kriteria6.update');
        Route::delete('/kriteria6/{id}', [Kriteria6Controller::class, 'destroy'])->name('kriteria6.destroy');
    });

    Route::middleware(['authorize:A7'])->group(function () {
        Route::get('/kriteria7/input', [Kriteria7Controller::class, 'create'])->name('kriteria7.input');
        Route::get('/kriteria7', [Kriteria7Controller::class, 'index'])->name('kriteria7.index');
        Route::post('/kriteria7', [Kriteria7Controller::class, 'store'])->name('kriteria7.store');
        Route::post('/kriteria7/list', [Kriteria7Controller::class, 'list'])->name('kriteria.7.list');
        Route::get('/kriteria7/{id}/show', [Kriteria7Controller::class, 'preview'])->name('kriteria7.detail');
        Route::get('/kriteria7/{id}/preview-pdf', [Kriteria7Controller::class, 'previewpdf'])->name('kriteria7.preview-pdf');
        Route::get('/kriteria7/{id}/edit', [Kriteria7Controller::class, 'edit'])->name('kriteria7.edit');
        Route::put('/kriteria7/{id}', [Kriteria7Controller::class, 'update'])->name('kriteria7.update');
        Route::delete('/kriteria7/{id}', [Kriteria7Controller::class, 'destroy'])->name('kriteria7.destroy');
    });

    Route::middleware(['authorize:A8'])->group(function () {
        Route::get('/kriteria8/input', [Kriteria8Controller::class, 'create'])->name('kriteria8.input');
        Route::get('/kriteria8', [Kriteria8Controller::class, 'index'])->name('kriteria8.index');
        Route::post('/kriteria8', [Kriteria8Controller::class, 'store'])->name('kriteria8.store');
        Route::post('/kriteria8/list', [Kriteria8Controller::class, 'list'])->name('kriteria.8.list');
        Route::get('/kriteria8/{id}/show', [Kriteria8Controller::class, 'preview'])->name('kriteria8.detail');
        Route::get('/kriteria8/{id}/preview-pdf', [Kriteria8Controller::class, 'previewpdf'])->name('kriteria8.preview-pdf');
        Route::get('/kriteria8/{id}/edit', [Kriteria8Controller::class, 'edit'])->name('kriteria8.edit');
        Route::put('/kriteria8/{id}', [Kriteria8Controller::class, 'update'])->name('kriteria8.update');
        Route::delete('/kriteria8/{id}', [Kriteria8Controller::class, 'destroy'])->name('kriteria8.destroy');
    });

    Route::middleware(['authorize:A9'])->group(function () {
        Route::get('/kriteria9/input', [Kriteria9Controller::class, 'create'])->name('kriteria9.input');
        Route::get('/kriteria9', [Kriteria9Controller::class, 'index'])->name('kriteria9.index');
        Route::post('/kriteria9', [Kriteria9Controller::class, 'store'])->name('kriteria9.store');
        Route::post('/kriteria9/list', [Kriteria9Controller::class, 'list'])->name('kriteria.9.list');
        Route::get('/kriteria9/{id}/show', [Kriteria9Controller::class, 'preview'])->name('kriteria9.detail');
        Route::get('/kriteria9/{id}/preview-pdf', [Kriteria9Controller::class, 'previewpdf'])->name('kriteria9.preview-pdf');
        Route::get('/kriteria9/{id}/edit', [Kriteria9Controller::class, 'edit'])->name('kriteria9.edit');
        Route::put('/kriteria9/{id}', [Kriteria9Controller::class, 'update'])->name('kriteria9.update');
        Route::delete('/kriteria9/{id}', [Kriteria9Controller::class, 'destroy'])->name('kriteria9.destroy');
    });

Route::get('/validasiDirektur', [ValidasiDirController::class, 'index'])->name('validasi.index')->middleware('authorize:KJR');
Route::post('/validasiDirektur/list', [ValidasiDirController::class, 'list'])->name('validasi.list')->middleware('authorize:KJR');
Route::post('/validasiDirektur/show', [ValidasiDirController::class, 'show'])->name('validasi.show')->middleware('authorize:KJR');
Route::post('/validasiDirektur/pdf', [ValidasiDirController::class, 'generatePdfDetailKriteriaBatch'])->name('validasi.pdf')->middleware('authorize:KJR');
Route::post('/validasiDirektur/update', [ValidasiDirController::class, 'update'])->name('validasi.update')->middleware('authorize:KJR');

});
