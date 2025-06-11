<?php

namespace App\Http\Controllers;

use App\Models\PengisianModel;
use App\Models\DetailKriteriaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class DokumenFinalController extends Controller
{
    public function index()
    {
        // Tampilkan halaman Dokumen Final
        return view('dokumenFinal.index');
    }

   public function list(Request $request)
    {
        $pengisian = PengisianModel::select('pengisian.id_pengisian', 'pengisian.nama_pengisian', 'pengisian.created_at')
            ->join('detail_kriteria', 'pengisian.id_pengisian', '=', 'detail_kriteria.id_pengisian')
            ->where('detail_kriteria.status', 'acc2')
            ->groupBy('pengisian.id_pengisian', 'pengisian.nama_pengisian', 'pengisian.created_at')
            ->havingRaw('COUNT(DISTINCT detail_kriteria.id_kriteria) = 9');

        return DataTables::of($pengisian)
            ->addIndexColumn()
            ->addColumn('tanggal', function ($row) {
                return $row->created_at ? $row->created_at->format('Y-m-d') : '-';
            })
           ->addColumn('status', function ($row) {
    return 'ACC2 (9 Kriteria)';
})
            ->addColumn('aksi', function ($row) {
                $url = route('dokumenFinal.generatePdf', $row->id_pengisian);
                return '
                    <div class="btn-action-group d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-info btn-sm btn-preview-pdf" data-url="'.$url.'">
                            <i class="fas fa-eye"></i> Preview
                        </button>
                        <a href="'.$url.'" target="_blank" download class="btn btn-primary btn-sm">
                            <i class="fas fa-file-pdf"></i> Download PDF
                        </a>
                    </div>
                ';
            })
            ->rawColumns(['status', 'aksi'])
            ->make(true);
    }


    public function generatePdf($id_pengisian)
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

        // --- Tambahkan gambar sebagai Base64 ---
        foreach ($details as $detail) {
            $detail->penetapan_image = $this->convertImagePathToBase64(optional($detail->penetapan)->pendukung);
            $detail->pelaksanaan_image = $this->convertImagePathToBase64(optional($detail->pelaksanaan)->pendukung);
            $detail->evaluasi_image = $this->convertImagePathToBase64(optional($detail->evaluasi)->pendukung);
            $detail->pengendalian_image = $this->convertImagePathToBase64(optional($detail->pengendalian)->pendukung);
            $detail->peningkatan_image = $this->convertImagePathToBase64(optional($detail->peningkatan)->pendukung);
        }

        // --- Generate PDF ---
        $pdf = Pdf::loadView('validasiDirektur.pdf', compact('batch', 'details'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream("Dokumen_Final_{$batch->nama_pengisian}.pdf");
    }

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
}
