<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('perusahaan')->insert([
            [
                'nama' => 'PT. Maju Mundur',
                'instansi' => 'BUMN',
                'no_telepon' => '021-1234567',
                'email' => 'info@majumundur.com',
                'nama_alumni' => 'John Doe',
                'program_studi' => 'Teknik Informatika',
                'tahun_lulus' => '2020-10-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT. Bangun Jaya',
                'instansi' => 'Swasta',
                'no_telepon' => '022-9876543',
                'email' => 'hrd@bangunjaya.co.id',
                'nama_alumni' => 'Jane Smith',
                'program_studi' => 'Sistem Informasi',
                'tahun_lulus' => '2019-08-17',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'CV. Cepat Selesai',
                'instansi' => 'Lainnya',
                'no_telepon' => '031-5432109',
                'email' => 'cs@cepatselesai.com',
                'nama_alumni' => 'David Lee',
                'program_studi' => 'Manajemen',
                'tahun_lulus' => '2021-03-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT. Digital Solusi',
                'instansi' => 'BUMN',
                'no_telepon' => '021-8889990',
                'email' => 'recruitment@digitalsolusi.co.id',
                'nama_alumni' => 'Sarah Williams',
                'program_studi' => 'Teknik Informatika',
                'tahun_lulus'  => '2022-11-22',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nama' => 'PT. Karya Bersama',
                'instansi' => 'Swasta',
                'no_telepon' => '022-7778889',
                'email' => 'karir@karyabersama.com',
                'nama_alumni' => 'Michael Brown',
                'program_studi' => 'Sistem Informasi',
                'tahun_lulus'  => '2023-06-10',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
