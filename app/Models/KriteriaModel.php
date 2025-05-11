<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KriteriaModel extends Model
{
    use HasFactory;

    protected $table = "m_kriteria";
    protected $primaryKey = "id_kriteria";
    protected $fillable = ['nama_kriteria'];

    public function penetapan(): HasMany
    {
        return $this->hasMany(PenetapanModel::class);
    }

    public function pelaksanaan(): HasMany
    {
        return $this->hasMany(PelaksanaanModel::class);
    }

    public function evaluasi(): HasMany
    {
        return $this->hasMany(PenetapanModel::class);
    }

    public function peningkatan(): HasMany
    {
        return $this->hasMany(PeningkatanModel::class);
    }

    public function pengendalian(): HasMany
    {
        return $this->hasMany(PengendalianModel::class);
    }

    public function detail(): HasMany
    {
        return $this->hasMany(DetailKriteriaModel::class);
    }
}