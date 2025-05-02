<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AlumniBelumIsiSurveiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('alumni')
            ->leftJoin('survei_alumni', 'alumni.nim', '=', 'survei_alumni.nim')
            ->whereNull('survei_alumni.nim')
            ->select('alumni.program_studi', 'alumni.nim', 'alumni.nama', 'alumni.tanggal_lulus')
            ->get();
    }

    public function headings(): array
    {
        return ['Program Studi', 'NIM', 'Nama', 'Tanggal Lulus'];
    }
}