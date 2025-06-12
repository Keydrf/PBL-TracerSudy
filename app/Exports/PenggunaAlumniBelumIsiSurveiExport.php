<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PenggunaAlumniBelumIsiSurveiExport implements FromCollection, WithHeadings, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate . ' 00:00:00';
        $this->endDate = $endDate . ' 23:59:59';
    }

    public function collection()
    {
        $query = DB::table('survei_alumni')
            ->leftJoin('survei_perusahaan', 'survei_alumni.nim', '=', 'survei_perusahaan.nim')
            ->join('alumni', 'survei_alumni.nim', '=', 'alumni.nim')
            ->whereNull('survei_perusahaan.survei_perusahaan_id')
            ->select(
                'survei_alumni.nama_atasan AS nama',
                'survei_alumni.nama_instansi AS instansi',
                'survei_alumni.jabatan_atasan AS jabatan',
                'survei_alumni.no_telepon_atasan AS no_telepon',
                'survei_alumni.email_atasan AS email',
                'alumni.nama AS nama_alumni',
                'alumni.program_studi',
                'survei_alumni.tahun_lulus'
            );

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('alumni.created_at', [$this->startDate, $this->endDate]);
        }

        return $query->get();
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

    public function styles(Worksheet $sheet)
    {
        return [
            // Baris pertama (header)
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FF0070C0',
                    ],
                ],
            ],
        ];
    }
}