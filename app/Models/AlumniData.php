<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniData extends Model
{
    use HasFactory;

    protected $fillable = ['prodi', 'kategori_profesi', 'profesi'];
}
