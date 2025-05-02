<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SurveyPenggunaLulusanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('survei_perusahaan')
            ->join('alumni', 'survei_perusahaan.nim', '=', 'alumni.nim')
            ->select(
                'survei_perusahaan.nama',
                'survei_perusahaan.instansi',
                'survei_perusahaan.jabatan',
                'survei_perusahaan.email',
                'alumni.nama AS nama_alumni',
                'alumni.program_studi AS program_studi_alumni',
                'alumni.tanggal_lulus AS tahun_lulus',
                'survei_perusahaan.kerjasama',
                'survei_perusahaan.keahlian',
                'survei_perusahaan.kemampuan_basing',
                'survei_perusahaan.kemampuan_komunikasi',
                'survei_perusahaan.pengembangan_diri',
                'survei_perusahaan.kepemimpinan',
                'survei_perusahaan.etoskerja',
                'survei_perusahaan.kompetensi_yang_belum_dipenuhi',
                'survei_perusahaan.saran'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Instansi',
            'Jabatan',
            'Email',
            'Nama Alumni',
            'Program Studi',
            'Tahun Lulus',
            'Kerjasama Tim',
            'Keahlian di bidang TI',
            'Kemampuan berbahasa asing',
            'Kemampuan berkomunikasi',
            'Pengembangan diri',
            'Kepemimpinan',
            'Etos Kerja',
            'Kompetensi yang dibutuhkan tapi belum dapat dipenuhi',
            'Saran untuk kurikulum program studi'
        ];
    }
}
