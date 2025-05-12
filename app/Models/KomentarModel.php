<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KomentarModel extends Model
{
    use HasFactory;

    protected $table = "komentar";
    protected $primaryKey = "id_komentar";
    protected $fillable = ['komentar'];

    public function details(): HasMany
    {
        return $this->hasMany(DetailKriteriaModel::class);
    }
}