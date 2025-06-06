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


class Kriteria4Controller extends Controller
{
    // Menampilkan daftar kriteria yang belum divalidasi
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kriteria Empat',
            'list' => ['Kriteria', 'Kriteria4']
        ];

        $page = (object) [
            'title' => 'Kriteria 4 - Statuta Polinema',
        ];

        $activeMenu = 'kriteria';
        $activeSubmenu = 'kriteria4';

        return view('kriteria4.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'activeSubmenu' => $activeSubmenu
        ]);
    }

    public function create()
    {
        return view('kriteria4.input');
    }

    public function list(Request $request)
    {
        $userRole = auth()->user()->role->role_kode;
        $details = DetailKriteriaModel::with('kriteria:id_kriteria,nama_kriteria')
            ->select('id_detail_kriteria', 'id_kriteria', 'status')
            ->whereIn('id_kriteria',[4]);

        if (!in_array($userRole, ['A4'])) {
        $details->whereIn('status', ['submitted','acc1','acc2']);
    }
        //Filter data berdasarkan id_detail_kriteria
        if ($request->id_detail_kriteria) {
            $details->where('id_detail_kriteria', $request->id_detail_kriteria);
        }

        return DataTables::of($details)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request)
{

    $status = $request->input('status');
    $id_kriteria = 4; // karena ini store untuk Kriteria 1

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

    $batches = PengisianModel::withCount(['detailKriteria'])
        ->having('detail_kriteria_count', '<', 9)
        ->orderBy('id_pengisian', 'asc')
        ->get();

    $availableBatch = null;

    foreach ($batches as $batch) {
        $exists = DetailKriteriaModel::where('id_pengisian', $batch->id_pengisian)
            ->where('id_kriteria', $id_kriteria)
            ->exists();


        if (!$exists) {
            $availableBatch = $batch;
            break;
        }
    }

    if (!$availableBatch) {
    $lastId = PengisianModel::max('id_pengisian') ?? 0;
$nomorBatch = $lastId + 1;

    $availableBatch = PengisianModel::create([
        'nama_pengisian' => 'Pengisian ke-' . $nomorBatch,
    ]);
}


    $batch = $availableBatch;

   
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

    $penetapan     = $saveModel(PenetapanModel::class, 'penetapan', 'pendukung_penetapan', 'penetapan');
    $pelaksanaan   = $saveModel(PelaksanaanModel::class, 'pelaksanaan', 'pendukung_pelaksanaan', 'pelaksanaan');
    $evaluasi      = $saveModel(EvaluasiModel::class, 'evaluasi', 'pendukung_evaluasi', 'evaluasi');
    $pengendalian  = $saveModel(PengendalianModel::class, 'pengendalian', 'pendukung_pengendalian', 'pengendalian');
    $peningkatan   = $saveModel(PeningkatanModel::class, 'peningkatan', 'pendukung_peningkatan', 'peningkatan');

    // 🔗 Simpan DetailKriteria
    $detail = new DetailKriteriaModel();
    $detail->id_kriteria      = $id_kriteria;
    $detail->id_penetapan     = $penetapan->id ?? $penetapan->id_penetapan;
    $detail->id_pelaksanaan   = $pelaksanaan->id ?? $pelaksanaan->id_pelaksanaan;
    $detail->id_evaluasi      = $evaluasi->id ?? $evaluasi->id_evaluasi;
    $detail->id_pengendalian  = $pengendalian->id ?? $pengendalian->id_pengendalian;
    $detail->id_peningkatan   = $peningkatan->id ?? $peningkatan->id_peningkatan;
    $detail->id_pengisian     = $batch->id_pengisian;
    $detail->status           = $status;
    $detail->save();

    return redirect()->route('kriteria4.index')->with('success', 'Data berhasil disimpan');
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

        return view('kriteria4.detail', [
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

        return view('kriteria4.update', compact('detail'));
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

        $detail = DetailKriteriaModel::findOrFail($id);

        $penetapan = $detail->penetapan;
        $penetapan->deskripsi = $validated['penetapan'];
        if ($request->hasFile('pendukung_penetapan')) {
            if ($penetapan->pendukung && Storage::disk('public')->exists($penetapan->pendukung)) {
                Storage::disk('public')->delete($penetapan->pendukung);
            }
            $penetapan->pendukung = $request->file('pendukung_penetapan')->store('penetapan', 'public');
        }
        $penetapan->save();

        $pelaksanaan = $detail->pelaksanaan;
        $pelaksanaan->deskripsi = $validated['pelaksanaan'];
        if ($request->hasFile('pendukung_pelaksanaan')) {
            if ($pelaksanaan->pendukung && Storage::disk('public')->exists($pelaksanaan->pendukung)) {
                Storage::disk('public')->delete($pelaksanaan->pendukung);
            }
            $pelaksanaan->pendukung = $request->file('pendukung_pelaksanaan')->store('pelaksanaan', 'public');
        }
        $pelaksanaan->save();

        $evaluasi = $detail->evaluasi;
        $evaluasi->deskripsi = $validated['evaluasi'];
        if ($request->hasFile('pendukung_evaluasi')) {
            if ($evaluasi->pendukung && Storage::disk('public')->exists($evaluasi->pendukung)) {
                Storage::disk('public')->delete($evaluasi->pendukung);
            }
            $evaluasi->pendukung = $request->file('pendukung_evaluasi')->store('evaluasi', 'public');
        }
        $evaluasi->save();

        $pengendalian = $detail->pengendalian;
        $pengendalian->deskripsi = $validated['pengendalian'];
        if ($request->hasFile('pendukung_pengendalian')) {
            if ($pengendalian->pendukung && Storage::disk('public')->exists($pengendalian->pendukung)) {
                Storage::disk('public')->delete($pengendalian->pendukung);
            }
            $pengendalian->pendukung = $request->file('pendukung_pengendalian')->store('pengendalian', 'public');
        }
        $pengendalian->save();

        $peningkatan = $detail->peningkatan;
        $peningkatan->deskripsi = $validated['peningkatan'];
        if ($request->hasFile('pendukung_peningkatan')) {
            if ($peningkatan->pendukung && Storage::disk('public')->exists($peningkatan->pendukung)) {
                Storage::disk('public')->delete($peningkatan->pendukung);
            }
            $peningkatan->pendukung = $request->file('pendukung_peningkatan')->store('peningkatan', 'public');
        }
        $peningkatan->save();

        $detail->status = $status;
        $detail->save();

        return redirect()->route('kriteria4.index')->with('success', 'Data berhasil diupdate');
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

    $pdf = Pdf::loadView('kriteria4.preview-pdf', $data);
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

    return redirect()->route('kriteria4.index')->with('success', 'Data berhasil dihapus');
}




    
}