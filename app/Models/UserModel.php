<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LevelModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; // implemetasi class Authenticable
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable
{
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }
    protected $table = 'user';
    protected $primaryKey = 'admin_id';
    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];
    protected $fillable = ['username', 'nama', 'password', 'level_id'];

    use HasFactory;
    public function level(): BelongsTo

    // Relasi ke tabel Level
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    // Mendapatkan nama role
    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }

    // Cek apakah user memiliki role tertentu
    public function hasRole($role): bool
    {
        if (!$this->level) {
            return false;
        }

        if (is_array($role)) {
            return in_array($this->level->level_kode, $role);
        }

        return $this->level->level_kode === $role;
    }

    // Mendapatkan kode role
    public function getRole()
    {
        return $this->level->level_kode;
    }
}
