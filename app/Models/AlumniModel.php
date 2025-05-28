<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniModel extends Model
{
    use HasFactory;

    protected $table = 'alumni';
    protected $primaryKey = 'alumni_id';

    protected $fillable = ['program_studi', 'nim', 'nama', 'tanggal_lulus', 'kode_otp_alumni', 'email'];

    protected $casts = [
        'tanggal_lulus' => 'date',
    ];

    /**
     * Scope untuk filter survei alumni berdasarkan tahun lulus dan program studi.
     */
    public function scopeFilterBySurvei($query, $tahunAwal = null, $tahunAkhir = null, $programStudi = null)
    {
        return $query->join('survei_alumni', 'survei_alumni.nim', '=', 'alumni.nim')
            ->when($tahunAwal && $tahunAkhir, function ($q) use ($tahunAwal, $tahunAkhir) {
                $q->whereBetween('tahun_lulus', [$tahunAwal, $tahunAkhir]);
            })
            ->when($programStudi, function ($q) use ($programStudi) {
                $q->where('alumni.program_studi', $programStudi);
            });
    }
}
