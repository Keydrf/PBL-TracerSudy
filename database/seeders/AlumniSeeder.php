<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('alumni')->insert([
            [
                'program_studi' => 'Teknik Informatika',
                'nim' => '2341760193',
                'nama' => 'Keysha Arindra Fabian',
                'tanggal_lulus' => '2023-10-26',
                'kode_otp' => 'KA93',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_studi' => 'Sistem Informasi Bisnis',
                'nim' => '2341760093',
                'nama' => 'Dinarul Lailil Mubarokah',
                'tanggal_lulus' => '2023-12-01',
                'kode_otp' => 'DL93',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_studi' => 'Pengembangan Perangkat Lunak Situs',
                'nim' => '2341760149',
                'nama' => 'Adit Bagus Sadewa',
                'tanggal_lulus' => '2022-07-01',
                'kode_otp' => 'AB49',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_studi' => 'Sistem Informasi Bisnis',
                'nim' => '2341760113',
                'nama' => 'Satrio Dian Nugroho',
                'tanggal_lulus' => '2024-05-15',
                'kode_otp' => 'SD13',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_studi' => 'Teknik Informatika',
                'nim' => '2341760056',
                'nama' => 'Emily Brown',
                'tanggal_lulus' => '2023-03-10',
                'kode_otp' => 'EB56',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
