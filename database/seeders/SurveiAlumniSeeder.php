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
                'nim' => '1234567890',
                'no_telepon' => '081234567890',
                'email' => 'john.doe@example.com',
                'tahun_lulus' => 2023,
                'tanggal_pertama_kerja' => '2024-01-15',
                'masa_tunggu' => 3,
                'tanggal_pertama_kerja_instansi_saat_ini' => '2024-05-10',
                'jenis_instansi' => 'Perusahaan Swasta',
                'nama_instansi' => 'PT. Maju Mundur',
                'skala' => 'Nasional',
                'lokasi_instansi' => 'Jakarta',
                'profesi_id' => 1, // Contoh: ID Profesi Software Engineer
                'pendapatan' => 10000000,
                'alamat_kantor' => 'Jln. Apel No. 5',
                'kabupaten' => 'Kab. Buah',
                'kategori_id' => 1, // Contoh: ID Kategori Bidang Infokom
                'nama_atasan' => 'Jane Smith',
                'jabatan_atasan' => 'Project Manager',
                'no_telepon_atasan' => '08987654321',
                'email_atasan' => 'jane.smith@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '4321098765',
                'no_telepon' => '082345678901',
                'email' => 'jane.doe@example.com',
                'tahun_lulus' => 2022,
                'tanggal_pertama_kerja' => '2023-02-20',
                'masa_tunggu' => 6,
                'tanggal_pertama_kerja_instansi_saat_ini' => '2024-04-01',
                'jenis_instansi' => 'Instansi Pemerintah',
                'nama_instansi' => 'Kementerian Pendidikan',
                'skala' => 'Nasional',
                'lokasi_instansi' => 'Jakarta',
                'profesi_id' => 9, // Contoh: ID Profesi Trainer / Guru / Dosen (IT)
                'pendapatan' => 9000000,
                'alamat_kantor' => 'Jln. Mangga No. 3',
                'kabupaten' => 'Kab. Buah',
                'kategori_id' => 1, // Contoh: ID Kategori Bidang Infokom
                'nama_atasan' => 'John Smith',
                'jabatan_atasan' => 'Kepala Bagian',
                'no_telepon_atasan' => '081122334455',
                'email_atasan' => 'john.smith@kemenag.go.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '6677889900',
                'no_telepon' => '083456789012',
                'email' => 'andi.setiawan@example.com',
                'tahun_lulus' => 2021,
                'tanggal_pertama_kerja' => '2022-03-15',
                'masa_tunggu' => 9,
                'tanggal_pertama_kerja_instansi_saat_ini' => '2023-06-15',
                'jenis_instansi' => 'BUMN',
                'nama_instansi' => 'PT. Telkom Indonesia',
                'skala' => 'Nasional',
                'lokasi_instansi' => 'Bandung',
                'profesi_id' => 2, // Contoh: ID Profesi IT Support / IT Administrator
                'pendapatan' => 12000000,
                'alamat_kantor' => 'Jln. Anggur No. 7',
                'kabupaten' => 'Kab. Buah',
                'kategori_id' => 1, // Contoh: ID Kategori Bidang Infokom
                'nama_atasan' => 'Rini Sukaesih',
                'jabatan_atasan' => 'Manager IT',
                'no_telepon_atasan' => '082233445566',
                'email_atasan' => 'rini.sukaesih@telkom.co.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '3344556677',
                'no_telepon' => '084567890123',
                'email' => 'siti.nurhaliza@example.com',
                'tahun_lulus' => 2020,
                'tanggal_pertama_kerja' => '2021-05-01',
                'masa_tunggu' => 12,
                'tanggal_pertama_kerja_instansi_saat_ini' => '2022-08-01',
                'jenis_instansi' => 'Perusahaan Swasta',
                'nama_instansi' => 'PT. Astra Internasional',
                'skala' => 'Nasional',
                'lokasi_instansi' => 'Surabaya',
                'profesi_id' => 11, // Contoh: ID Profesi Procurement & Operational Team
                'pendapatan' => 15000000,
                'alamat_kantor' => 'Jln. Manggis No. 9',
                'kabupaten' => 'Kab. Buah',
                'kategori_id' => 2, // Contoh: ID Kategori Bidang Non Infokom
                'nama_atasan' => 'Budi Santoso',
                'jabatan_atasan' => 'Supervisor Procurement',
                'no_telepon_atasan' => '083344556677',
                'email_atasan' => 'budi.santoso@astra.co.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '4455667788',
                'no_telepon' => '085678901234',
                'email' => 'eko.prasetyo@example.com',
                'tahun_lulus' => 2024,
                'tanggal_pertama_kerja' => '2024-07-01',
                'masa_tunggu' => 1,
                'tanggal_pertama_kerja_instansi_saat_ini' => '2024-09-01',
                'jenis_instansi' => 'Pendidikan Tinggi',
                'nama_instansi' => 'PT. Gojek Indonesia',
                'skala' => 'Nasional',
                'lokasi_instansi' => 'Yogyakarta',
                'profesi_id' => 4, // Contoh: ID Profesi Digital Marketing Specialist
                'pendapatan' => 20000000,
                'alamat_kantor' => 'Jln. Duren No. 12',
                'kabupaten' => 'Kab. Buah',
                'kategori_id' => 1, // Kategori Infokom
                'nama_atasan' => 'Nadiem Makarim',
                'jabatan_atasan' => 'CEO',
                'no_telepon_atasan' => '089988776655',
                'email_atasan' => 'nadiem.makarim@gojek.com',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
