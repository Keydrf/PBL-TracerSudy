<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TracerStudyLulusanExport implements FromCollection, WithHeadings, WithStyles
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
            ->join('alumni', 'survei_alumni.nim', '=', 'alumni.nim')
            ->select(
                'alumni.program_studi AS program_studi',
                'survei_alumni.nim',
                'alumni.nama AS nama_alumni',
                'survei_alumni.no_telepon',
                'survei_alumni.email',
                'alumni.tanggal_lulus',
                'survei_alumni.tahun_lulus',
                'survei_alumni.tanggal_pertama_kerja',
                'survei_alumni.masa_tunggu',
                'survei_alumni.tanggal_pertama_kerja_instansi_saat_ini',
                'survei_alumni.jenis_instansi',
                'survei_alumni.nama_instansi',
                'survei_alumni.skala',
                'survei_alumni.lokasi_instansi',
                'survei_alumni.kategori_id AS kategori_profesi',
                'survei_alumni.profesi_id AS profesi',
                'survei_alumni.pendapatan',
                'survei_alumni.alamat_kantor',
                'survei_alumni.kabupaten',
                'survei_alumni.nama_atasan',
                'survei_alumni.jabatan_atasan',
                'survei_alumni.no_telepon_atasan',
                'survei_alumni.email_atasan'
            );

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('alumni.created_at', [$this->startDate, $this->endDate]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Program Studi',
            'NIM',
            'Nama',
            'No. HP',
            'Email',
            'Tanggal Lulus',
            'Tahun Lulus',
            'Tanggal Pertama Kerja',
            'Masa Tunggu',
            'Tanggal Mulai Kerja Instansi Saat Ini',
            'Jenis Instansi',
            'Nama Instansi',
            'Skala',
            'Lokasi Instansi',
            'Kategori Profesi',
            'Profesi',
            'Pendapatan',
            'Alamat Kantor',
            'Kabupaten',
            'Nama Atasan Langsung',
            'Jabatan Atasan Langsung',
            'No. HP Atasan Langsung',
            'Email Atasan Langsung'
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