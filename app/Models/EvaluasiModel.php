<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EvaluasiModel extends Model
{
    use HasFactory;

    protected $table = "evaluasi";
    protected $primaryKey = "id_evaluasi";
    protected $fillable = ['id_kriteria', 'evaluasi', 'pendukung'];

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(KriteriaModel::class, 'id_kriteria', 'id_kriteria');
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailKriteriaModel::class);
    }
}