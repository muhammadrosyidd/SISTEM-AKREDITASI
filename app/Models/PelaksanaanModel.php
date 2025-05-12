<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PelaksanaanModel extends Model
{
    use HasFactory;

    protected $table = "pelaksanaan";
    protected $primaryKey = "id_pelaksanaan";
    protected $fillable = ['id_kriteria', 'pelaksanaan', 'pendukung'];

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(KriteriaModel::class, 'id_kriteria', 'id_kriteria');
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailKriteriaModel::class);
    }
}