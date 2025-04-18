<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProfesiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('profesi')->insert([
            // Kategori Infokom (1)
            [
                'nama_profesi' => 'Developer / Programmer / Software Engineer',
                'kategori_id' => '1', // Menggunakan kategori_id sebagai foreign key
                'deskripsi' => 'Merancang, mengembangkan, dan memelihara perangkat lunak.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'IT Support / IT Administrator',
                'kategori_id' => '1',
                'deskripsi' => 'Memberikan dukungan teknis dan mengelola sistem IT organisasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Infrastructure Engineer',
                'kategori_id' => '1',
                'deskripsi' => 'Merancang, membangun, dan memelihara infrastruktur IT.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Digital Marketing Specialist',
                'kategori_id' => '1',
                'deskripsi' => 'Mengembangkan dan melaksanakan strategi pemasaran digital.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Graphic Designer / Multimedia Designer',
                'kategori_id' => '1',
                'deskripsi' => 'Merancang elemen visual untuk berbagai media.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Business Analyst',
                'kategori_id' => '1',
                'deskripsi' => 'Menganalisis kebutuhan bisnis dan memberikan solusi IT.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'QA Engineer / Tester',
                'kategori_id' => '1',
                'deskripsi' => 'Memastikan kualitas perangkat lunak melalui pengujian.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'IT Enterpreneur',
                'kategori_id' => '1',
                'deskripsi' => 'Membangun dan mengelola bisnis di bidang teknologi informasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Trainer / Guru / Dosen (IT)',
                'kategori_id' => '1',
                'deskripsi' => 'Mengajar dan melatih individu di bidang teknologi informasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Mahasiswa (IT)',
                'kategori_id' => '1',
                'deskripsi' => 'Sedang menempuh pendidikan di bidang teknologi informasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kategori Non Infokom (2)
            [
                'nama_profesi' => 'Procurement & Operational Team',
                'kategori_id' => '2',
                'deskripsi' => 'Mengelola pengadaan barang/jasa dan operasional perusahaan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Wirausahawan (Non IT)',
                'kategori_id' => '2',
                'deskripsi' => 'Menjalankan usaha di luar bidang teknologi informasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Trainer / Guru / Dosen (Non IT)',
                'kategori_id' => '2',
                'deskripsi' => 'Mengajar dan melatih individu di luar bidang teknologi informasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Mahasiswa (Non IT)',
                'kategori_id' => '2',
                'deskripsi' => 'Sedang menempuh pendidikan di luar bidang teknologi informasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Belum Bekerja',
                'kategori_id' => '3',
                'deskripsi' => 'Belum memiliki pekerjaan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
