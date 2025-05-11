<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use HasFactory;

    protected $table = 'role'; // Nama tabel di database
    protected $primaryKey = 'id_role'; // Primary key khusus

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'kode',
        'nama',
    ];

    /**
     * Relasi ke tabel user (satu role bisa dimiliki banyak user)
     */
    public function users()
    {
        return $this->hasMany(UserModel::class, 'id_role', 'id_role');
    }
}
