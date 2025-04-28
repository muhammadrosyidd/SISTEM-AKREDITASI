<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class ValidasiController extends Controller
{
    // Menampilkan daftar kriteria yang belum divalidasi
    public function index()
    {
        return view('validasi.index');
    }
}