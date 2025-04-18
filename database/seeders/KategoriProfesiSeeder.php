<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KategoriProfesiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori_profesi')->insert([
            [
                'kode_kategori' => 'K001',
                'nama_kategori' => 'Bidang Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kategori' => 'K002',
                'nama_kategori' => 'Bidang Non Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kategori' => 'K003',
                'nama_kategori' => 'Belum Bekerja',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}
