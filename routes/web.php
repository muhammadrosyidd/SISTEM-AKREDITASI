<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KriteriaController;

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

