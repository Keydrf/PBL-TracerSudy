<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SurveiAlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada data alumni dengan NIM yang sesuai di database Anda sebelum menjalankan seeder ini
        // Jika tidak, Anda akan mendapatkan error foreign key constraint.

        DB::table('survei_alumni')->insert([
            [
                'nim' => '1234567890', // Ganti dengan NIM alumni yang ada di tabel alumni
                'no_telepon' => '081234567890',
                'email' => 'john.doe@example.com',
                'tahun_lulus' => 2023,
                'tanggal_pertama_kerja' => '2024-01-15',
                'masa_tunggu' => 3,
                'tanggal_pertama_kerja_instansi_saat_ini' => '2024-05-10',
                'jenis_instansi' => 'Swasta',
                'nama_instansi' => 'PT. Maju Mundur',
                'skala' => 'Nasional',
                'lokasi_instansi' => 'Jakarta',
                'kategori_profesi' => 'K001', // Contoh, pastikan ada kategori ini di tabel kategori_profesi
                'profesi' => 'Software Engineer', // Contoh, pastikan ada profesi ini di tabel profesi
                'nama_atasan' => 'Jane Smith',
                'jabatan_atasan' => 'Project Manager',
                'no_telepon_atasan' => '08987654321',
                'email_atasan' => 'jane.smith@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
           
        ]);
    }
}
