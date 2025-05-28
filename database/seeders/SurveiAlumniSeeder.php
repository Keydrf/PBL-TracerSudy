<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SurveiAlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data alumni untuk mapping kode_otp berdasarkan nim
        $alumni = DB::table('alumni')->select('nim', 'kode_otp_alumni')->get()->keyBy('nim');

        // Data survei alumni
        $data = [
            [
                'nim' => '2341760193',
                'no_telepon' => '081234567891',
                'email' => 'keysha.arindra@example.com',
                'tahun_lulus' => 2023,
                'tanggal_pertama_kerja' => '2024-01-15',
                'masa_tunggu' => 3,
                'tanggal_pertama_kerja_instansi_saat_ini' => '2024-05-10',
                'jenis_instansi' => 'Perusahaan Swasta',
                'nama_instansi' => 'PT. Teknologi Nusantara',
                'skala' => 'Nasional',
                'lokasi_instansi' => 'Jakarta',
                'profesi_id' => 1,
                'pendapatan' => 10000000,
                'alamat_kantor' => 'Jl. Mawar No. 10',
                'kabupaten' => 'Kab. Bunga',
                'kategori_id' => 1,
                'nama_atasan' => 'Agus Pramono',
                'jabatan_atasan' => 'CTO',
                'no_telepon_atasan' => '081111111111',
                'email_atasan' => 'agus.pramono@ptnusa.co.id',
            ],
            [
                'nim' => '2341760093',
                'no_telepon' => '082345678902',
                'email' => 'dinarul.lailil@example.com',
                'tahun_lulus' => 2023,
                'tanggal_pertama_kerja' => '2024-02-01',
                'masa_tunggu' => 2,
                'tanggal_pertama_kerja_instansi_saat_ini' => '2024-04-15',
                'jenis_instansi' => 'Instansi Pemerintah',
                'nama_instansi' => 'Dinas Kominfo',
                'skala' => 'Daerah',
                'lokasi_instansi' => 'Malang',
                'profesi_id' => 2,
                'pendapatan' => 9000000,
                'alamat_kantor' => 'Jl. Kenanga No. 5',
                'kabupaten' => 'Kab. Apel',
                'kategori_id' => 1,
                'nama_atasan' => 'Rina Hartati',
                'jabatan_atasan' => 'Kepala Seksi',
                'no_telepon_atasan' => '082222222222',
                'email_atasan' => 'rina.hartati@kominfo.go.id',
            ],
            [
                'nim' => '2341760149',
                'no_telepon' => '083456789012',
                'email' => 'adit.bagus@example.com',
                'tahun_lulus' => 2022,
                'tanggal_pertama_kerja' => '2022-09-01',
                'masa_tunggu' => 2,
                'tanggal_pertama_kerja_instansi_saat_ini' => '2023-03-10',
                'jenis_instansi' => 'BUMN',
                'nama_instansi' => 'PT. Telkom Indonesia',
                'skala' => 'Nasional',
                'lokasi_instansi' => 'Bandung',
                'profesi_id' => 11,
                'pendapatan' => 12000000,
                'alamat_kantor' => 'Jl. Melati No. 12',
                'kabupaten' => 'Kab. Bunga',
                'kategori_id' => 2,
                'nama_atasan' => 'Eko Santoso',
                'jabatan_atasan' => 'Manajer Divisi',
                'no_telepon_atasan' => '083333333333',
                'email_atasan' => 'eko.santoso@telkom.co.id',
            ],
        ];

        // Loop dan tambahkan kode_otp dari alumni serta auto generate kode_otp_perusahaan
        foreach ($data as &$item) {
            $nim = $item['nim'];
            $item['kode_otp_alumni'] = $alumni[$nim]->kode_otp_alumni ?? strtoupper(Str::random(4)); // fallback jika tidak ditemukan
            // Generate OTP perusahaan: 2 huruf kapital + 2 angka, sama seperti di controller
            $item['kode_otp_perusahaan'] = strtoupper(Str::random(2)) . str_pad(strval(random_int(0, 99)), 2, '0', STR_PAD_LEFT);
            $item['created_at'] = now();
            $item['updated_at'] = now();
        }

        // Insert ke tabel survei_alumni
        DB::table('survei_alumni')->insert($data);
    }
}
