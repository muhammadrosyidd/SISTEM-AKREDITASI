<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use App\Models\KomentarModel;
use App\Models\PengisianModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\DetailKriteriaModel;
use Yajra\DataTables\Facades\DataTables;

class ValidasiDirController extends Controller
{
    // Menampilkan daftar kriteria yang belum divalidasi
    public function index()
    {
        return view('validasiDirektur.index');
    }

    public function list(Request $request)
    {
        $pengisian = PengisianModel::with([
            'detailKriteria' => function ($q) {
                $q->whereIn('status', ['submitted', 'revisi']);
            }
        ])
            ->select('id_pengisian', 'nama_pengisian', 'created_at');

        return DataTables::of($pengisian)
            ->addIndexColumn()
            ->addColumn('tanggal', function ($row) {
                return $row->created_at ? $row->created_at->format('Y-m-d') : '-';
            })
            ->addColumn('status', function ($row) {
                return $row->detailKriteria->pluck('status')->unique()->implode(', ') ?: '-';
            })
            ->addColumn('id_pengisian', function ($row) {
                return $row->id_pengisian;
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    public function show(Request $request)
    {
        $id_pengisian = $request->input('id');
        // Ambil semua DetailKriteria beserta relasi utama untuk batch ini
        $details = DetailKriteriaModel::with([
            'penetapan',
            'pelaksanaan',
            'evaluasi',
            'pengendalian',
            'peningkatan',
            'kriteria'
        ])
            ->where('id_pengisian', $id_pengisian)
            ->orderBy('id_kriteria')
            ->get();

        if ($details->isEmpty()) {
            abort(404, "Data batch tidak ditemukan.");
        }

        // Nama batch dari model Pengisian
        $batch = PengisianModel::find($id_pengisian);

        return view('validasiDirektur.validasi', [
            'batch' => $batch,
            'details' => $details,
        ]);
    }

    public function generatePdfDetailKriteriaBatch($id_pengisian)
    {
        $details = DetailKriteriaModel::with([
            'kriteria',
            'komentar',
            'penetapan',
            'pelaksanaan',
            'evaluasi',
            'pengendalian',
            'peningkatan',
        ])
            ->where('id_pengisian', $id_pengisian)
            ->orderBy('id_kriteria')
            ->get();

        if ($details->isEmpty()) {
            abort(404, "Data detail kriteria untuk batch dengan ID $id_pengisian tidak ditemukan.");
        }

        $batch = PengisianModel::find($id_pengisian);

        $pdf = PDF::loadView('validasiDirektur.pdf', compact('batch', 'details'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream("Detail_Kriteria_Batch_{$batch->nama_pengisian}.pdf");
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_pengisian' => 'required|exists:pengisian,id_pengisian',
            'status' => 'required|in:acc,revisi',
            'detail_revisi' => 'required_if:status,revisi|array',
            'detail_revisi.*' => 'exists:detail_kriteria,id_detail_kriteria',
            'catatan_kriteria' => 'required_if:status,revisi|array',
            'catatan_kriteria.*' => 'nullable|string',
        ]);

        $id_pengisian = $request->id_pengisian;
        $status = $request->status;
        $detailRevisi = $request->detail_revisi ?? [];
        $catatanKriteria = $request->catatan_kriteria ?? [];

        DB::beginTransaction();
        try {
            // Ambil semua detail untuk id_pengisian ini
            $details = DetailKriteriaModel::where('id_pengisian', $id_pengisian)->get();

            foreach ($details as $detail) {
                if ($status === 'acc') {
                    $detail->status = 'acc2'; // status diterima
                    // Hapus komentar jika ada
                    if ($detail->komentar) {
                        $detail->komentar()->delete();
                        $detail->id_komentar = null;
                    }
                } elseif ($status === 'revisi') {
                    if (in_array($detail->id_detail_kriteria, $detailRevisi)) {
                        $detail->status = 'revisi';

                        $komen = $catatanKriteria[$detail->id_detail_kriteria] ?? null;
                        if ($komen !== null) {
                            if ($detail->id_komentar) {
                                // Update komentar yang sudah ada, sekaligus update id_kriteria
                                $detail->komentar()->update([
                                    'komen' => $komen,
                                    'id_kriteria' => $detail->id_kriteria
                                ]);
                            } else {
                                // Buat komentar baru dengan komen dan id_kriteria
                                $komentar = KomentarModel::create([
                                    'komen' => $komen,
                                    'id_kriteria' => $detail->id_kriteria
                                ]);
                                $detail->id_komentar = $komentar->id_komentar;
                            }
                        }
                    } else {
                        $detail->status = 'acc2'; // selain kriteria revisi dianggap acc
                        if ($detail->komentar) {
                            $detail->komentar()->delete();
                            $detail->id_komentar = null;
                        }
                    }
                }
                $detail->save();
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Validasi berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}