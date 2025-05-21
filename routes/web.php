<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
=======
>>>>>>> kriteria
use App\Http\Controllers\KriteriaController;

use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});



Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postlogin'])->name('login.post');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/kriteria1', [KriteriaController::class, 'kriteria1'])->name('kriteria.1')->middleware('authorize:A1');
Route::get('/kriteria2', [KriteriaController::class, 'kriteria2'])->name('kriteria.2')->middleware('authorize:A2');
Route::get('/validasi', [ValidasiController::class, 'index'])->name('validasi.index')->middleware('authorize:KJR');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

<<<<<<< HEAD
=======

Route::get('/validasi', [ValidasiController::class, 'index'])->name('validasi.index');
Route::get('/kriteria1/input', [KriteriaController::class, 'create'])->name('kriteria.1.input');
Route::get('/kriteria1', [KriteriaController::class, 'index'])->name('kriteria.index');
Route::post('/kriteria1', [KriteriaController::class, 'store'])->name('kriteria1.store');
Route::post('kriteria1/list', [KriteriaController::class, 'list'])->name('kriteria.1.list');
Route::get('/kriteria1/{id}/show', [KriteriaController::class, 'preview'])->name('kriteria.detail');
Route::get('/kriteria1/{id}/preview-pdf', [KriteriaController::class, 'previewpdf'])->name('kriteria1.preview-pdf');
Route::get('/kriteria1/{id}/edit', [KriteriaController::class, 'edit'])->name('kriteria1.edit');
Route::put('/kriteria1/{id}', [KriteriaController::class, 'update'])->name('kriteria1.update');
Route::delete('/kriteria1/{id}', [KriteriaController::class, 'destroy'])->name('kriteria1.destroy');




>>>>>>> kriteria
