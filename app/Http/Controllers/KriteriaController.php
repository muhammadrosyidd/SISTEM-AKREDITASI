<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    // Menampilkan daftar kriteria yang belum divalidasi
    public function kriteria1()
    {
        return view('kriteria1.index');
    }

    public function kriteria2()
    {
        return view('kriteria2.index');
    }
}