<?php

namespace App\Http\Controllers;

use App\Models\DetailKriteriaModel;
use App\Models\KriteriaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class ValidasiController extends Controller
{
    public function index()
    {
        return view('validasi.index');
    }

    public function list(Request $request)
    {
        $details = DetailKriteriaModel::with('kriteria')
            ->whereIn('status', ['submitted', 'revisi', 'acc1'])
            ->orderBy('detail_kriteria.created_at', 'desc');

        return DataTables::of($details)
            ->addIndexColumn()
            ->addColumn('nama_kriteria', function ($row) {
                return $row->kriteria->nama_kriteria ?? '-';
            })
            ->addColumn('tanggal', function ($row) {
                return [
                    'display' => $row->created_at ? Carbon::parse($row->created_at)->format('d/m/Y') : '-',
                    'timestamp' => $row->created_at ? $row->created_at->timestamp : 0
                ];
            })
            ->addColumn('status', function ($row) {
                return $row->status;
            })
            ->addColumn('aksi', function ($row) {
                if ($row->status === 'acc1') {
                    return '';
                }
                return '<button type="button" class="btn-validasi btn-detail" data-id="' . $row->id_detail_kriteria . '">Validasi</button>';
            })
            ->orderColumn('tanggal', function ($query, $order) {
                $query->orderBy('detail_kriteria.created_at', $order);
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function modalDetail($id)
    {
        $detail = DetailKriteriaModel::with([
            'kriteria',
        ])->find($id);

        $existingCommentText = '';
        if ($detail && $detail->id_komentar) {
            $komentar = DB::table('komentar')->where('id_komentar', $detail->id_komentar)->first();
            if ($komentar) {
                $existingCommentText = $komentar->komen;
            }
        }
        return view('validasi.modal', compact('detail', 'existingCommentText'));
    }

    public function validateDocument(Request $request)
    {
        $request->validate([
            'id_detail_kriteria' => 'required|exists:detail_kriteria,id_detail_kriteria',
            'action' => 'required|in:acc1,revisi',
            'comment' => 'nullable|string|max:255'
        ]);

        $detail = DetailKriteriaModel::with('kriteria')->find($request->id_detail_kriteria);

        if (!$detail) {
            return response()->json(['success' => false, 'message' => 'Data detail kriteria tidak ditemukan.'], 404);
        }

        $detail->status = $request->action;

        if ($request->action === 'revisi') {
            if ($request->filled('comment')) {
                $komentarData = [
                    'komen' => $request->comment,
                    'id_kriteria' => $detail->id_kriteria, // Pastikan ini ada di tabel detail_kriteria
                ];

                if ($detail->id_komentar) {
                    DB::table('komentar')
                        ->where('id_komentar', $detail->id_komentar)
                        ->update($komentarData);
                } else {
                    $newKomentarId = DB::table('komentar')
                        ->insertGetId($komentarData);
                    $detail->id_komentar = $newKomentarId;
                }
            } else {
                if ($detail->id_komentar) {
                    $detail->id_komentar = null;
                }
            }
        }

        $detail->save();

        return response()->json(['success' => true, 'message' => 'Validasi berhasil disimpan.']);
    }
}