<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'program_studi' => 'D4 Teknik Informatika',
                'nim' => '2341760193',
                'nama' => 'Keysha Arindra Fabian',
                'email' => 'key@gmail.com',
                'tanggal_lulus' => '2023-10-26',
            ],
            [
                'program_studi' => 'D4 Sistem Informasi Bisnis',
                'nim' => '2341760093',
                'nama' => 'Dinarul Lailil Mubarokah',
                'email' => 'din@gmail.com',
                'tanggal_lulus' => '2023-12-01',
            ],
            [
                'program_studi' => 'D2 Pengembangan Perangkat Lunak Situs',
                'nim' => '2341760149',
                'nama' => 'Adit Bagus Sadewa',
                'email' => 'adi@gmail.com',
                'tanggal_lulus' => '2022-07-01',
            ],
            [
                'program_studi' => 'D4 Sistem Informasi Bisnis',
                'nim' => '2341760113',
                'nama' => 'Satrio Dian Nugroho',
                'email' => 'sat@gmail.com',
                'tanggal_lulus' => '2024-05-15',
            ],
            [
                'program_studi' => 'D4 Teknik Informatika',
                'nim' => '2341760056',
                'nama' => 'Emily Brown',
                'email' => 'emi@gmail.com',
                'tanggal_lulus' => '2023-03-10',
            ],
        ];

        foreach ($data as &$alumni) {
            $inisial = strtoupper(substr($alumni['nama'], 0, 1));
            // ambil huruf pertama dari nama depan dan nama belakang
            $nama_parts = explode(' ', $alumni['nama']);
            if (count($nama_parts) > 1) {
                $inisial = strtoupper(substr($nama_parts[0], 0, 1) . substr(end($nama_parts), 0, 1));
            }
            $nim_suffix = substr($alumni['nim'], -2);
            $alumni['kode_otp_alumni'] = $inisial . $nim_suffix;
            $alumni['created_at'] = now();
            $alumni['updated_at'] = now();
        }

        DB::table('alumni')->insert($data);
    }
}
