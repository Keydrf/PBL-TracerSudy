<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KategoriProfesiModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfesiModel extends Model
{
    protected $table = 'profesi';
    protected $primaryKey = 'profesi_id';

    protected $fillable = ['nama_profesi', 'deskripsi', 'kategori_id'];
    use HasFactory;

    public function kategori_profesi(): BelongsTo
    {
        return $this->belongsTo(KategoriProfesiModel::class, 'kategori_id', 'kategori_id');
    }
}
