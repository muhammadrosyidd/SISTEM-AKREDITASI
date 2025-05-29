<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengisianModel extends Model
{
    use HasFactory;

    protected $table = 'pengisian'; // nama tabel
    protected $primaryKey = 'id_pengisian'; // kolom primary key
    protected $fillable = ['nama_pengisian']; // kolom yang bisa di-assign

    // Relasi dengan DetailKriteriaModel (batch untuk detail kriteria)
    public function detailKriteria()
    {
        return $this->hasMany(DetailKriteriaModel::class, 'id_pengisian');
    }
}
