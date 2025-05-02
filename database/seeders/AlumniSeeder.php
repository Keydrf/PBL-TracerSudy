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
            // Tambahkan data alumni lainnya di sini
            [
                'program_studi' => 'Sistem Informasi Bisnis',
                'nim' => '1122334455',
                'nama' => 'Alice Johnson',
                'tanggal_lulus' => '2024-05-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_studi' => 'Sistem Informasi Bisnis',
                'nim' => '6677889900',
                'nama' => 'Bob Smith',
                'tanggal_lulus' => '2024-08-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_studi' => 'Teknik Informatika',
                'nim' => '2233445566',
                'nama' => 'Emily Brown',
                'tanggal_lulus' => '2023-03-10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_studi' => 'Pengembangan Perangkat Lunak Situs',
                'nim' => '7788990011',
                'nama' => 'David Wilson',
                'tanggal_lulus' => '2022-11-05',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_studi' => 'Teknik Informatika',
                'nim' => '3344556677',
                'nama' => 'Jessica Davis',
                'tanggal_lulus' => '2025-01-22',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                 'program_studi' => 'Teknik Informatika',
                 'nim' => '8899001122',
                 'nama' => 'Kevin Martinez',
                 'tanggal_lulus' => '2024-09-18',
                 'created_at' => now(),
                 'updated_at' => now(),
            ],
            [
                 'program_studi' => 'Sistem Informasi Bisnis',
                  'nim' => '4455667788',
                  'nama' => 'Laura Garcia',
                  'tanggal_lulus' => '2023-06-28',
                  'created_at' => now(),
                  'updated_at' => now(),
            ],
        ]);
    }
}
