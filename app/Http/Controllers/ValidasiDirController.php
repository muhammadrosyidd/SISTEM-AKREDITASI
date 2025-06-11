<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use App\Models\KomentarModel;
use App\Models\PengisianModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\DetailKriteriaModel;
use Illuminate\Support\Facades\Log;
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
    $pengisian = PengisianModel::select('pengisian.id_pengisian', 'pengisian.nama_pengisian', 'pengisian.created_at')
        ->join('detail_kriteria', function($join) {
            $join->on('pengisian.id_pengisian', '=', 'detail_kriteria.id_pengisian')
                 ->where('detail_kriteria.status', ['acc1','acc2']);
        })
        ->groupBy('pengisian.id_pengisian', 'pengisian.nama_pengisian', 'pengisian.created_at')
        ->havingRaw('COUNT(DISTINCT detail_kriteria.id_kriteria) = 9');

    return DataTables::of($pengisian)
        ->addIndexColumn()
        ->addColumn('tanggal', function ($row) {
            return $row->created_at ? $row->created_at->format('Y-m-d') : '-';
        })
        ->addColumn('status', function ($row) {
            // Sudah valid by havingRaw
            return 'acc1 (9 kriteria)';
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

     private function fileUrl($path)
{
    if (!$path) return null;
    return asset('storage/'.str_replace('public/', '', $path));
}

    // Untuk preview pdf, gunakan fileUrl untuk menampilkan gambar
   private function convertImagePathToBase64($path)
{
    if (!$path) {
        Log::warning('convertImagePathToBase64: Path kosong.');
        return '';
    }

    try {
        $relativePath = str_replace('public/', '', $path);
        $fullPath = storage_path('app/public/' . $relativePath);

        if (!file_exists($fullPath)) {
            Log::error('convertImagePathToBase64: File tidak ditemukan - ' . $fullPath);
            return '';
        }

        // Cek ekstensi yang aman untuk DomPDF
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExtensions)) {
            Log::error("convertImagePathToBase64: File extension .$extension tidak didukung DomPDF.");
            return '';
        }

        // Encode + chunk supaya DomPDF tidak error pada gambar besar
        $data = base64_encode(file_get_contents($fullPath));
        $chunkedData = chunk_split($data);

        Log::info('convertImagePathToBase64: Success untuk file - ' . $fullPath);

        return '<img src="data:image/' . $extension . ';base64,' . $chunkedData . '" style="max-width:300px; max-height:300px;" />';
    } catch (\Exception $e) {
        Log::error('convertImagePathToBase64: Exception - ' . $e->getMessage());
        return '';
    }
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

    // --- ✨ Tambahkan gambar sebagai Base64 ---
    foreach ($details as $detail) {
        $detail->penetapan_image = $this->convertImagePathToBase64(optional($detail->penetapan)->pendukung);
        $detail->pelaksanaan_image = $this->convertImagePathToBase64(optional($detail->pelaksanaan)->pendukung);
        $detail->evaluasi_image = $this->convertImagePathToBase64(optional($detail->evaluasi)->pendukung);
        $detail->pengendalian_image = $this->convertImagePathToBase64(optional($detail->pengendalian)->pendukung);
        $detail->peningkatan_image = $this->convertImagePathToBase64(optional($detail->peningkatan)->pendukung);
    }

    // --- Generate PDF ---
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
        $detail->status = 'acc2'; // semua acc
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
                    // Update komentar yang sudah ada
                    $detail->komentar()->update([
                        'komen' => $komen,
                        'id_kriteria' => $detail->id_kriteria
                    ]);
                } else {
                    // Buat komentar baru
                    $komentar = KomentarModel::create([
                        'komen' => $komen,
                        'id_kriteria' => $detail->id_kriteria
                    ]);
                    $detail->id_komentar = $komentar->id_komentar;
                }
            }
        } else {
            // Yang tidak direvisi → status dibiarkan (tidak dipaksa ke acc2)
            if ($detail->komentar) {
                $detail->komentar()->delete();
                $detail->id_komentar = null;
            }
            // $detail->status tidak diubah
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