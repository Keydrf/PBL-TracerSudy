<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AlumniBelumIsiSurveiExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = DB::table('alumni')
            ->leftJoin('survei_alumni', 'alumni.nim', '=', 'survei_alumni.nim')
            ->whereNull('survei_alumni.nim')
            ->select('alumni.program_studi', 'alumni.nim', 'alumni.nama', 'alumni.tanggal_lulus');

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('alumni.created_at', [$this->startDate, $this->endDate]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return ['Program Studi', 'NIM', 'Nama', 'Tanggal Lulus'];
    }
}
