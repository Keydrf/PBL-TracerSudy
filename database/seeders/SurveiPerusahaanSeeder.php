<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveiPerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kepuasan = ['kurang', 'cukup', 'baik', 'sangat baik'];

        // Ambil mapping nim -> kode_otp_perusahaan dari survei_alumni
        $kodeOtpMap = DB::table('survei_alumni')
            ->select('nim', 'kode_otp_perusahaan')
            ->get()
            ->keyBy('nim');

        $perusahaanList = [
            [
                'nama' => 'Kementerian Pendidikan',
                'instansi' => 'Instansi Pemerintah',
                'jabatan' => 'Manajer',
                'no_telepon' => '081234567890',
                'email' => 'abc@example.com',
                'nim' => '2341760193',
                'kompetensi_yang_belum_dipenuhi' => 'Sangat Baik',
                'saran' => 'Pertahankan kualitas alumni.',
                // 'perusahaan_id' => 1
            ],
            [
                'nama' => 'PT. Telkom Indonesia',
                'instansi' => 'BUMN',
                'jabatan' => 'Supervisor',
                'no_telepon' => '082234567891',
                'email' => 'xyz@example.com',
                'nim' => '2341760093',
                'kompetensi_yang_belum_dipenuhi' => 'Baik',
                'saran' => 'Tingkatkan kemampuan komunikasi.',
                // 'perusahaan_id' => 1
            ]
        ];

        $data = [];

        foreach ($perusahaanList as $index => $perusahaan) {
            $nim = $perusahaan['nim'];
            // Ambil kode OTP perusahaan dari survei_alumni (harus sama persis)
            $kodeOtpPerusahaan = $kodeOtpMap[$nim]->kode_otp_perusahaan ?? null;

            if (!$kodeOtpPerusahaan) {
                continue; // skip jika tidak ditemukan
            }

            $data[] = array_merge($perusahaan, [
                'kode_otp_perusahaan' => $kodeOtpPerusahaan,
                'kerjasama' => $kepuasan[array_rand($kepuasan)],
                'keahlian' => $kepuasan[array_rand($kepuasan)],
                'kemampuan_basing' => $kepuasan[array_rand($kepuasan)],
                'kemampuan_komunikasi' => $kepuasan[array_rand($kepuasan)],
                'pengembangan_diri' => $kepuasan[array_rand($kepuasan)],
                'kepemimpinan' => $kepuasan[array_rand($kepuasan)],
                'etoskerja' => $kepuasan[array_rand($kepuasan)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('survei_perusahaan')->insert($data);
    }
}
