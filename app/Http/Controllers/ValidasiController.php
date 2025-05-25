<?php

namespace App\Http\Controllers;

use App\Models\DetailKriteriaModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Log;

class ValidasiController extends Controller
{
    // Menampilkan daftar kriteria yang belum divalidasi
    public function index()
    {
        return view('validasi.index');
    }

    // Menampilkan data yang sudah disubmit dan dalam status revisi
    public function list(Request $request)
    {
        $details = DetailKriteriaModel::with('kriteria:id_kriteria,nama_kriteria')
            ->select('id_detail_kriteria', 'id_kriteria', 'status', 'created_at') // tambah created_at untuk tanggal
            ->whereIn('status', ['submitted', 'revisi']); // filter status hanya submitted & revisi

        // Opsional: filter berdasarkan id_detail_kriteria jika ada parameter
        if ($request->id_detail_kriteria) {
            $details->where('id_detail_kriteria', $request->id_detail_kriteria);
        }

        return DataTables::of($details)
            ->addIndexColumn()
            ->addColumn('nama_kriteria', function ($row) {
                return $row->kriteria->nama_kriteria ?? '-';
            })
            ->addColumn('tanggal', function ($row) {
                return $row->created_at ? $row->created_at->format('Y-m-d') : '-';
            })
            ->make(true);
    }
}
