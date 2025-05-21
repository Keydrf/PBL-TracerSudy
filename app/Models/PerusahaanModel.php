<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerusahaanModel extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';

    protected $primaryKey = 'perusahaan_id';

    public $incrementing = true;

    protected $keyType = 'integer';

    public $timestamps = true;

    // Tambahkan survei_alumni_id ke fillable karena wajib diisi saat insert/update
    protected $fillable = [
        'survei_alumni_id',  // HARUS ADA supaya bisa mass assignable
        'nama_atasan',
        'instansi',
        'nama_instansi',
        'no_telepon',
        'email',
        'nama_alumni',
        'program_studi',
        'tahun_lulus',
    ];

    protected $casts = [
        'tahun_lulus' => 'datetime',
    ];

    public function surveiAlumni()
    {
        // Relasi ke model SurveiAlumniModel dengan foreign key survei_alumni_id
        return $this->belongsTo(SurveiAlumniModel::class, 'survei_alumni_id', 'survei_alumni_id');
    }
}
