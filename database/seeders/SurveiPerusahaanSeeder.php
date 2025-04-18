<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SurveiPerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada data alumni dengan NIM yang sesuai di database Anda sebelum menjalankan seeder ini
        // Jika tidak, Anda akan mendapatkan error foreign key constraint.

        $kepuasan = ['kurang', 'cukup', 'baik', 'sangat baik'];

        DB::table('survei_perusahaan')->insert([
            [
                'nama' => 'PT. ABC',
                'instansi' => 'Swasta',
                'jabatan' => 'Manajer',
                'no_telepon' => '081234567890',
                'email' => 'abc@example.com',
                'nim' => '1234567890', // Ganti dengan NIM alumni yang ada
                'kerjasama' => $kepuasan[array_rand($kepuasan)],
                'keahlian' => $kepuasan[array_rand($kepuasan)],
                'kemampuan_basing' => $kepuasan[array_rand($kepuasan)],
                'kemampuan_komunikasi' => $kepuasan[array_rand($kepuasan)],
                'pengembangan_diri' => $kepuasan[array_rand($kepuasan)],
                'kepemimpinan' => $kepuasan[array_rand($kepuasan)],
                'etoskerja' => $kepuasan[array_rand($kepuasan)],
                'kompetensi' => 'Sangat Baik',
                'saran' => 'Pertahankan kualitas alumni.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}
