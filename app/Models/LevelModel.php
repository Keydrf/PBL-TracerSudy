<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    protected $table = 'level';
    protected $primaryKey = 'level_id';

    protected $fillable = ['level_kode', 'level_nama'];
    use HasFactory;

    public function users()
    {
        return $this->hasMany(UserModel::class, 'level_id', 'level_id');
    }
}
