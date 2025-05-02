<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumniDataSeeder extends Seeder
{
    public function run()
    {
        DB::table('alumni_data')->insert([
            ['prodi' => 'TI', 'kategori_profesi' => 'Bidang Infokom', 'profesi' => 'Developer'],
            ['prodi' => 'TI', 'kategori_profesi' => 'Bidang Infokom', 'profesi' => 'IT Support'],
            ['prodi' => 'S', 'kategori_profesi' => 'Belum Bekerja', 'profesi' => ''],
            ['prodi' => 'PPL Situs', 'kategori_profesi' => 'Non Infokom', 'profesi' => 'Desainer'],
            ['prodi' => 'TI', 'kategori_profesi' => 'Bidang Infokom', 'profesi' => 'System Analyst'],
            ['prodi' => 'S', 'kategori_profesi' => 'Non Infokom', 'profesi' => 'Admin'],
            // Tambah data sesuai kebutuhan
        ]);
    }
}
