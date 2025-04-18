<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gunakan DB::table untuk memasukkan data
        DB::table('alumni')->insert([
            [
                'program_studi' => 'Teknik Informatika',
                'nim' => '1234567890',
                'nama' => 'John Doe',
                'tanggal_lulus' => '2023-10-26', // Contoh tanggal
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'program_studi' => 'Sistem Informasi Bisnis',
                'nim' => '4321098765',
                'nama' => 'Sarah Williams',
                'tanggal_lulus' => '2023-12-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_studi' => 'Pengembangan Perangkat Lunak Situs',
                'nim' => '9876543210',
                'nama' => 'Michael Brown',
                'tanggal_lulus' => '2022-07-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
