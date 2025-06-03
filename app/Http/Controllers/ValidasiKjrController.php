<?php

namespace App\Http\Controllers;

use App\Models\DetailKriteriaModel;
use App\Models\KriteriaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ValidasiKjrController extends Controller
{
    public function index()
    {
        return view('validasiKajur.index');
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
        return view('validasiKajur.modal', compact('detail', 'existingCommentText'));
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
                    'id_kriteria' => $detail->id_kriteria
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

    private function fileUrl($path)
    {
        if (!$path)
            return null;
        return asset('storage/' . str_replace('public/', '', $path));
    }

    // Untuk preview pdf, gunakan fileUrl untuk menampilkan gambar
    private function convertImagePathToBase64($path)
    {
        if (!$path)
            return '';

        try {
            $relativePath = str_replace('public/', '', $path);
            $fullPath = storage_path('app/public/' . $relativePath);

            if (file_exists($fullPath)) {
                $type = pathinfo($fullPath, PATHINFO_EXTENSION);
                $data = base64_encode(file_get_contents($fullPath));
                return '<img src="data:image/' . $type . ';base64,' . $data . '" style="max-width:300px;" />';
            }

            return '';
        } catch (\Exception $e) {
            return '';
        }
    }



    public function previewpdf($id)
    {
        $detail = DetailKriteriaModel::with(['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan', 'kriteria'])->findOrFail($id);

        $bagianData = [];

        foreach (['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'] as $bagian) {
            if ($detail->$bagian) {
                $html = $detail->$bagian->deskripsi ?? '-';

                // Ganti <p> dan <br> jadi newline supaya hasilnya rapi
                $html = preg_replace('/<(\/)?p>/i', "\n", $html);
                $html = preg_replace('/<br\s*\/?>/i', "\n", $html);

                // Strip tag kecuali <a>
                $allowed_tags = '<a><ul><li><table><td>';
                $deskripsi = strip_tags($html, $allowed_tags);

                $pendukung = $detail->$bagian->pendukung ?? '';

                if (str_contains($pendukung, '<img')) {
                    $pendukungConvert = $this->convertImagesToBase64($pendukung);
                } else {
                    $pendukungConvert = $this->convertImagePathToBase64($pendukung);
                }

                $bagianData[$bagian] = [
                    'deskripsi' => nl2br(($deskripsi)),  // tambahkan nl2br untuk convert \n jadi <br> di HTML blade
                    'pendukung' => $pendukungConvert,
                ];
            } else {
                $bagianData[$bagian] = [
                    'deskripsi' => '-',
                    'pendukung' => '',
                ];
            }
        }

        $data = [
            'detail' => $detail,
            'bagianData' => $bagianData,
        ];

        $pdf = Pdf::loadView('validasiKajur.pdf', $data);
        return $pdf->stream('preview.pdf');
    }
}
