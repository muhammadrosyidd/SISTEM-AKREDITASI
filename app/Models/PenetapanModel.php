<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenetapanModel extends Model
{
    use HasFactory;

    protected $table = "t_penetapan";
    protected $primaryKey = "id_penetapan";
    protected $fillable = ['id_kriteria', 'penetapan', 'pendukung'];

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(KriteriaModel::class, 'id_kriteria', 'id_kriteria');
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailKriteriaModel::class);
    }
}