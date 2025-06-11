<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\EvaluasiModel;
use App\Models\KriteriaModel;
use App\Models\PenetapanModel;
use App\Models\PengisianModel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PelaksanaanModel;
use App\Models\PeningkatanModel;
use App\Models\PengendalianModel;
use App\Models\DetailKriteriaModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;


class KriteriaController extends Controller
{
    // Menampilkan daftar kriteria yang belum divalidasi
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kriteria Satu',
            'list' => ['Kriteria', 'Kriteria1']
        ];

        $page = (object) [
            'title' => 'Kriteria 1 - Statuta Polinema',
        ];

        $activeMenu = 'kriteria';
        $activeSubmenu = 'kriteria1';

        return view('kriteria.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'activeSubmenu' => $activeSubmenu
        ]);
    }

    public function create()
    {
        return view('kriteria.input');
    }

    public function list(Request $request)
{
    $userRole = auth()->user()->role->role_kode;

    $details = DetailKriteriaModel::with([
            'kriteria:id_kriteria,nama_kriteria',
            'pengisian:id_pengisian,nama_pengisian'
        ])
        ->select('id_detail_kriteria', 'id_kriteria', 'status', 'id_pengisian')
        ->whereIn('id_kriteria', [1]);

    if (!in_array($userRole, ['A1'])) {
        $details->whereIn('status', ['submitted','acc1','acc2']);
    }

    if ($request->id_detail_kriteria) {
        $details->where('id_detail_kriteria', $request->id_detail_kriteria);
    }

    return DataTables::of($details)
        ->addIndexColumn()
        ->addColumn('batch', function ($row) {
            return $row->pengisian ? $row->pengisian->nama_pengisian : '-';
        })
        ->addColumn('batch_number', function ($row) {
            if ($row->pengisian && preg_match('/Dokumen Final ke-(\d+)/', $row->pengisian->nama_pengisian, $matches)) {
                return (int)$matches[1]; // Ambil angka batch
            }
            return 0; // Jika tidak ada batch, anggap 0
        })
        ->addColumn('aksi', function ($row) {
            $id = $row->id_detail_kriteria;
            $isEditable = ($row->status === 'save' || $row->status === 'revisi');
            $userRole = auth()->user()->role->role_kode;
            $base_url = url('kriteria1');

            $buttons = '<div class="btn-action-group d-flex justify-content-center">';
            $buttons .= '<button class="btn btn-info btn-sm" onclick="showDetail('.$id.')" title="Detail"><i class="fas fa-eye fa-xs"></i> Detail</button>';

            if ($userRole === 'A1') {
                $buttons .= '<a href="'.$base_url.'/'.$id.'/edit" class="btn btn-warning btn-sm '.($isEditable ? '' : 'disabled').'" title="Edit"><i class="fas fa-edit fa-xs"></i> Edit</a>';
                $buttons .= '<button class="btn btn-danger btn-sm" onclick="confirmDelete('.$id.')" title="Hapus"><i class="fas fa-trash fa-xs"></i> Hapus</button>';
            }

            $buttons .= '</div>';

            return $buttons;
        })
        ->rawColumns(['aksi'])
        ->make(true);
}


    public function store(Request $request)
{
    $status = $request->input('status');
    $id_kriteria = 1; // karena ini store untuk Kriteria 1

    // Validasi input
    $validated = $request->validate([
        'penetapan' => 'required|string|max:255',
        'pendukung_penetapan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10000',
        'pelaksanaan' => 'required|string|max:255',
        'pendukung_pelaksanaan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10000',
        'evaluasi' => 'required|string|max:255',
        'pendukung_evaluasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10000',
        'pengendalian' => 'required|string|max:255',
        'pendukung_pengendalian' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10000',
        'peningkatan' => 'required|string|max:255',
        'pendukung_peningkatan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10000',
    ]);

    // Reusable function untuk simpan model
    $saveModel = function ($class, $key, $fileKey, $folder) use ($validated, $request, $id_kriteria) {
        $model = new $class();
        $model->id_kriteria = $id_kriteria;
        $model->deskripsi = $validated[$key];

        if ($request->hasFile($fileKey)) {
            $path = $request->file($fileKey)->store($folder, 'public');
            $model->pendukung = $path;
        }

        $model->save();
        return $model;
    };

    // Simpan data
    $penetapan    = $saveModel(PenetapanModel::class, 'penetapan', 'pendukung_penetapan', 'penetapan');
    $pelaksanaan  = $saveModel(PelaksanaanModel::class, 'pelaksanaan', 'pendukung_pelaksanaan', 'pelaksanaan');
    $evaluasi     = $saveModel(EvaluasiModel::class, 'evaluasi', 'pendukung_evaluasi', 'evaluasi');
    $pengendalian = $saveModel(PengendalianModel::class, 'pengendalian', 'pendukung_pengendalian', 'pengendalian');
    $peningkatan  = $saveModel(PeningkatanModel::class, 'peningkatan', 'pendukung_peningkatan', 'peningkatan');

    // Simpan DetailKriteria
    $detail = new DetailKriteriaModel();
    $detail->id_kriteria      = $id_kriteria;
    $detail->id_penetapan     = $penetapan->id ?? $penetapan->id_penetapan;
    $detail->id_pelaksanaan   = $pelaksanaan->id ?? $pelaksanaan->id_pelaksanaan;
    $detail->id_evaluasi      = $evaluasi->id ?? $evaluasi->id_evaluasi;
    $detail->id_pengendalian  = $pengendalian->id ?? $pengendalian->id_pengendalian;
    $detail->id_peningkatan   = $peningkatan->id ?? $peningkatan->id_peningkatan;

    // Set id_pengisian hanya jika submitted
    if ($status === 'submitted') {
        $batch = $this->getOrCreateAvailableBatch($id_kriteria);
        $detail->id_pengisian = $batch->id_pengisian;
    } else {
        $detail->id_pengisian = null;
    }

    $detail->status = $status;
    $detail->save();

    return redirect()->route('kriteria.index')->with('success', 'Data berhasil disimpan');
}


private function getOrCreateAvailableBatch($id_kriteria)
{
    $batches = PengisianModel::withCount(['detailKriteria'])
        ->having('detail_kriteria_count', '<', 9)
        ->orderBy('id_pengisian', 'asc')
        ->get();

    foreach ($batches as $batch) {
        $exists = DetailKriteriaModel::where('id_pengisian', $batch->id_pengisian)
            ->where('id_kriteria', $id_kriteria)
            ->exists();

        if (!$exists) {
            return $batch;
        }
    }

    // Buat batch baru
    $lastFinalNumber = PengisianModel::where('nama_pengisian', 'like', 'Dokumen Final ke-%')
        ->orderByRaw('CAST(SUBSTRING(nama_pengisian, 18) AS UNSIGNED) DESC')
        ->value('nama_pengisian');

    if ($lastFinalNumber) {
        preg_match('/Dokumen Final ke-(\d+)/', $lastFinalNumber, $matches);
        $lastNumber = (int) ($matches[1] ?? 0);
    } else {
        $lastNumber = 0;
    }

    $nomorBatch = $lastNumber + 1;

    return PengisianModel::create([
        'nama_pengisian' => 'Dokumen Final ke-' . $nomorBatch,
    ]);
}



    public function preview($id)
    {
        $detail = DetailKriteriaModel::with([
            'kriteria',
            'penetapan',
            'pelaksanaan',
            'evaluasi',
            'pengendalian',
            'peningkatan',
        ])->findOrFail($id);

        return view('kriteria.detail', [
            'detail' => $detail,
            'penetapan' => $detail->penetapan,
            'pelaksanaan' => $detail->pelaksanaan,
            'evaluasi' => $detail->evaluasi,
            'pengendalian' => $detail->pengendalian,
            'peningkatan' => $detail->peningkatan,
            
        ]);
    }

    public function edit($id)
    {
        $detail = DetailKriteriaModel::with([
            'penetapan',
            'pelaksanaan',
            'evaluasi',
            'pengendalian',
            'peningkatan',
        ])->findOrFail($id);

        return view('kriteria.update', compact('detail'));
    }

    public function update(Request $request, $id)
{
    $status = $request->input('status');

    $validated = $request->validate([
        'penetapan' => 'required|string|max:255',
        'pendukung_penetapan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10000',
        'pelaksanaan' => 'required|string|max:255',
        'pendukung_pelaksanaan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10000',
        'evaluasi' => 'required|string|max:255',
        'pendukung_evaluasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10000',
        'pengendalian' => 'required|string|max:255',
        'pendukung_pengendalian' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10000',
        'peningkatan' => 'required|string|max:255',
        'pendukung_peningkatan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10000',
    ]);

    $detail = DetailKriteriaModel::with(['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'])->findOrFail($id);

    $models = [
        'penetapan' => 'pendukung_penetapan',
        'pelaksanaan' => 'pendukung_pelaksanaan',
        'evaluasi' => 'pendukung_evaluasi',
        'pengendalian' => 'pendukung_pengendalian',
        'peningkatan' => 'pendukung_peningkatan',
    ];

    foreach ($models as $bagian => $fileKey) {
        $model = $detail->$bagian;
        $model->deskripsi = $validated[$bagian];
        if ($request->hasFile($fileKey)) {
            if ($model->pendukung && Storage::disk('public')->exists($model->pendukung)) {
                Storage::disk('public')->delete($model->pendukung);
            }
            $model->pendukung = $request->file($fileKey)->store($bagian, 'public');
        }
        $model->save();
    }

    // Set id_pengisian hanya jika sebelumnya kosong DAN sekarang status jadi submitted
    if ($status === 'submitted' && !$detail->id_pengisian) {
        $batch = $this->getOrCreateAvailableBatch($detail->id_kriteria);
        $detail->id_pengisian = $batch->id_pengisian;
    }

    $detail->status = $status;
    $detail->save();

    return redirect()->route('kriteria.index')->with('success', 'Data berhasil diupdate');
}


    // Helper untuk convert path penyimpanan ke URL yang bisa diakses publik
    private function fileUrl($path)
{
    if (!$path) return null;
    return asset('storage/'.str_replace('public/', '', $path));
}

    // Untuk preview pdf, gunakan fileUrl untuk menampilkan gambar
    private function convertImagePathToBase64($path)
{
    if (!$path) return '';
    
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

    $pdf = Pdf::loadView('kriteria.preview-pdf', $data);
    return $pdf->stream('preview.pdf');
}


public function destroy($id)
{
    $detail = DetailKriteriaModel::with(['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'])->findOrFail($id);

    // Hapus dulu record detail_kriteria (karena dia referensi ke penetapan, dll)
    $detail->delete();

    // Setelah itu hapus data terkait dan file pendukungnya
    $models = [
        'penetapan' => $detail->penetapan,
        'pelaksanaan' => $detail->pelaksanaan,
        'evaluasi' => $detail->evaluasi,
        'pengendalian' => $detail->pengendalian,
        'peningkatan' => $detail->peningkatan,
    ];

    foreach ($models as $model) {
        if ($model) {
            if ($model->pendukung && Storage::disk('public')->exists($model->pendukung)) {
                Storage::disk('public')->delete($model->pendukung);
            }
            $model->delete();
        }
    }

    return redirect()->route('kriteria.index')->with('success', 'Data berhasil dihapus');
}




    
}