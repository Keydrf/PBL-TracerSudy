<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniModel extends Model
{
    protected $table = 'alumni';
    protected $primaryKey = 'alumni_id';

    protected $fillable = ['program_studi', 'nim', 'nama', 'tanggal_lulus'];
    use HasFactory;
}
