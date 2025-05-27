<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenggunaAlumniBelumIsiSurveiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('perusahaan')
            ->leftJoin('survei_perusahaan', 'perusahaan.perusahaan_id', '=', 'survei_perusahaan.perusahaan_id')
            ->leftJoin('survei_alumni', 'perusahaan.survei_alumni_id', '=', 'survei_alumni.survei_alumni_id')
            ->whereNull('survei_perusahaan.perusahaan_id')
            ->select(
                'perusahaan.nama_atasan',                               // Nama 
                'perusahaan.nama_instansi',                             // Instansi 
                'survei_alumni.jabatan_atasan AS jabatan',              // Jabatan
                'perusahaan.no_telepon',                                // No. HP 
                'perusahaan.email',                                     // Email 
                'perusahaan.nama_alumni',                               // Nama Alumni
                'perusahaan.program_studi',                             // Program Studi
                DB::raw('YEAR(perusahaan.tanggal_lulus) AS tahun_lulus')  // Hanya mengambil tahun
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