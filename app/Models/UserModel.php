<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LevelModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'admin_id';

    protected $fillable = ['username','nama', 'password', 'level_id'];
    use HasFactory;
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
}
