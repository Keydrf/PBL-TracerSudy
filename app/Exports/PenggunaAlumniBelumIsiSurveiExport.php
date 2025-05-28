<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenggunaAlumniBelumIsiSurveiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('survei_alumni')
            ->leftJoin('survei_perusahaan', 'survei_alumni.nim', '=', 'survei_perusahaan.nim')
            ->join('alumni', 'survei_alumni.nim', '=', 'alumni.nim') // Tambahkan join ke tabel alumni
            ->whereNull('survei_perusahaan.survei_perusahaan_id') // Ubah kondisi untuk mengecek keberadaan di survei_perusahaan
            ->select(
                'survei_alumni.nama_atasan AS nama',              // Nama 
                'survei_alumni.nama_instansi AS instansi',         // Instansi 
                'survei_alumni.jabatan_atasan AS jabatan',         // Jabatan
                'survei_alumni.no_telepon_atasan AS no_telepon',   // No. HP 
                'survei_alumni.email_atasan AS email',             // Email 
                'alumni.nama AS nama_alumni',                      // Nama Alumni
                'alumni.program_studi',                            // Program Studi
                'survei_alumni.tahun_lulus'                        // Tahun Lulus
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Instansi',
            'Jabatan',
            'No. HP',
            'Email',
            'Nama Alumni',
            'Program Studi',
            'Tahun Lulus'
        ];
    }
}