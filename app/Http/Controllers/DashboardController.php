<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailKriteriaModel;


class DashboardController extends Controller
{

    //fungsi untuk notifikasi
 public function updateStatus(Request $request, $id)
    {
        $detailKriteria = DetailKriteriaModel::findOrFail($id);
        $oldStatus = $detailKriteria->status;
        $detailKriteria->status = $request->input('status');
        $detailKriteria->save();

        if ($oldStatus !== $detailKriteria->status) {
            // Notifikasi dihasilkan saat status berubah, tapi tidak disimpan
            session()->flash('notification', $this->generateMessage($detailKriteria));
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }

    private function generateMessage($detailKriteria)
    {
        $IDkriteria = $detailKriteria->id_kriteria;
        switch ($detailKriteria->status) {
            case 'submitted':
                return "Kriteria {$IDkriteria} telah dikirim.";
            case 'revisi':
                return "Kriteria {$IDkriteria} memerlukan revisi.";
            case 'acc1':
                return "Kriteria {$IDkriteria} telah disetujui Kajur.";
            case 'acc2':
                return "Kriteria {$IDkriteria} telah disetujui Direktur.";
            default:
                return "Status kriteria {$IDkriteria} telah berubah.";
        }
    }
    
    public function index()
    {
        $recentChanges = DetailKriteriaModel::where('updated_at', '>=', now()->subDays(7))
        ->orderBy('updated_at', 'desc')
        ->take(10)
        ->get();

    $notifications = $recentChanges->map(function ($detailKriteria) {
        return [
            'message' => $this->generateMessage($detailKriteria),
            'created_at' => $detailKriteria->updated_at,
        ];
    });

    return view('layouts.dashboard', compact('notifications'));

    }

}