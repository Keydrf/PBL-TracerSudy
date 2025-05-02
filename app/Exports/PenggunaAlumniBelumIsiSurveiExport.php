<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenggunaAlumniBelumIsiSurveiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('alumni')
            ->leftJoin('survei_perusahaan', 'alumni.nim', '=', 'survei_perusahaan.nim')
            ->whereNull('survei_perusahaan.nim')
            ->select(
                DB::raw('NULL AS nama'),                  // Nama (perusahaan)
                DB::raw('NULL AS instansi'),              // Instansi (perusahaan)
                DB::raw('NULL AS jabatan'),               // Jabatan (perusahaan)
                DB::raw('NULL AS no_telepon'),            // No. HP (perusahaan)
                DB::raw('NULL AS email'),                 // Email (perusahaan)
                'alumni.nama AS nama_alumni',             // Nama Alumni
                'alumni.program_studi',
                'alumni.tanggal_lulus'
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
            'Tanggal Lulus'
        ];
    }
}