<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProfesiModel extends Model
{
    use HasFactory;
    protected $table = 'kategori_profesi'; // Nama tabel sesuai dengan database

    protected $primaryKey = 'kategori_id'; // Nama primary key

    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
    ];
}
