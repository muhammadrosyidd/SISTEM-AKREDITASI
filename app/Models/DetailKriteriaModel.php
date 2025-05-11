<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailKriteriaModel extends Model
{
    use HasFactory;

    protected $table = "t_detail_kriteria";
    protected $primaryKey = "id_detail_kriteria";
    protected $fillable = [
        'id_penetapan',
        'id_pelaksanaan',
        'id_evaluasi',
        'id_pengendalian',
        'id_peningkatan',
        'id_kriteria',
        'id_komentar',
        'status'
    ];

    public function penetapan(): BelongsTo
    {
        return $this->belongsTo(PenetapanModel::class, 'id_penetapan', 'id_penetapan');
    }

    public function pelaksanaan(): BelongsTo
    {
        return $this->belongsTo(PelaksanaanModel::class, 'id_pelaksanaan', 'id_pelaksanaan');
    }

    public function evaluasi(): BelongsTo
    {
        return $this->belongsTo(EvaluasiModel::class, 'id_evaluasi', 'id_evaluasi');
    }

    public function pengendalian(): BelongsTo
    {
        return $this->belongsTo(PengendalianModel::class, 'id_pengendalian', 'id_pengendalian');
    }

    public function peningkatan(): BelongsTo
    {
        return $this->belongsTo(PeningkatanModel::class, 'id_peningkatan', 'id_peningkatan');
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(KriteriaModel::class, 'id_kriteria', 'id_kriteria');
    }

    public function komentar(): BelongsTo
    {
        return $this->belongsTo(KomentarModel::class, 'id_komentar', 'id_komentar');
    }
}