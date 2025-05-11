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
                'nama' => 'Kementerian Pendidikan',
                'instansi' => 'Instansi Pemerintah',
                'jabatan' => 'Manajer',
                'no_telepon' => '081234567890',
                'email' => 'abc@example.com',
                'nim' => '4321098765', // Ganti dengan NIM alumni yang ada
                'kerjasama' => $kepuasan[array_rand($kepuasan)],
                'keahlian' => $kepuasan[array_rand($kepuasan)],
                'kemampuan_basing' => $kepuasan[array_rand($kepuasan)],
                'kemampuan_komunikasi' => $kepuasan[array_rand($kepuasan)],
                'pengembangan_diri' => $kepuasan[array_rand($kepuasan)],
                'kepemimpinan' => $kepuasan[array_rand($kepuasan)],
                'etoskerja' => $kepuasan[array_rand($kepuasan)],
                'kompetensi_yang_belum_dipenuhi' => 'Sangat Baik',
                'saran' => 'Pertahankan kualitas alumni.',
                'perusahaan_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT. Telkom Indonesia',
                'instansi' => 'BUMN',
                'jabatan' => 'Supervisor',
                'no_telepon' => '082234567891',
                'email' => 'xyz@example.com',
                'nim' => '6677889900', // Ganti dengan NIM alumni yang ada
                'kerjasama' => $kepuasan[array_rand($kepuasan)],
                'keahlian' => $kepuasan[array_rand($kepuasan)],
                'kemampuan_basing' => $kepuasan[array_rand($kepuasan)],
                'kemampuan_komunikasi' => $kepuasan[array_rand($kepuasan)],
                'pengembangan_diri' => $kepuasan[array_rand($kepuasan)],
                'kepemimpinan' => $kepuasan[array_rand($kepuasan)],
                'etoskerja' => $kepuasan[array_rand($kepuasan)],
                'kompetensi_yang_belum_dipenuhi' => 'Baik',
                'saran' => 'Tingkatkan kemampuan komunikasi.',
                'perusahaan_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            

        ]);
    }
}
