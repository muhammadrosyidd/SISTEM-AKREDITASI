<?php

namespace App\Models;

use App\Models\RoleModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $fillable = ['id_role', 'username', 'nama_user', 'password', 'created_at', 'updated_at'];

    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];

    // Override the authentication identifier to use 'username'
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(RoleModel::class, 'id_role', 'id_role');
    }

    public function getRoleName(): string
    {
        return $this->role->role_nama;
    }

    public function hasRole($role): bool
    {
        return $this->role->role_kode == $role;
    }

    public function getRole(): string
    {
        return $this->role->role_kode;
    }
}