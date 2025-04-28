<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\Auth\AuthController;
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



Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::get('/validasi', [ValidasiController::class, 'index'])->name('validasi.index');
Route::get('/kriteria1', [KriteriaController::class, 'index'])->name('kriteria.1');
