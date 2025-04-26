<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProfesi extends Model
{
    protected $table = 'kategori_profesi';
    protected $primaryKey = 'kategori_id';

    protected $fillable = ['nama_kategori'];
    use HasFactory;
}
