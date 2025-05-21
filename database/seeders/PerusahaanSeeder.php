<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SurveiAlumniModel;
use App\Models\PerusahaanModel;
use Carbon\Carbon;

class PerusahaanSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua data survei alumni
        $surveiAlumnis = SurveiAlumniModel::all();

        foreach ($surveiAlumnis as $alumni) {
            // Cek apakah data perusahaan dengan survei_alumni_id ini sudah ada
            $exists = PerusahaanModel::where('survei_alumni_id', $alumni->survei_alumni_id)->exists();

            if (!$exists) {
                PerusahaanModel::create([
                    'survei_alumni_id' => $alumni->survei_alumni_id,
                    'kode_perusahaan'  => $this->generateUniqueKodePerusahaan(),
                    'nama_atasan'      => $alumni->nama_atasan ?? 'Atasan Default',
                    'instansi'         => $alumni->jenis_instansi ?? 'Tidak Diketahui',
                    'nama_instansi'    => $alumni->nama_instansi ?? 'Tidak Diketahui',
                    'no_telepon'       => $alumni->no_telepon ?? '000000000',
                    'email'            => $alumni->email ?? 'email@default.com',
                    'nama_alumni'      => $alumni->nama_alumni ?? 'Alumni Tidak Dikenal',
                    'program_studi'    => $alumni->program_studi ?? 'Program Studi Tidak Diketahui',
                    'tahun_lulus'      => $alumni->tahun_lulus ?? Carbon::now()->subYears(rand(1, 5))->format('Y-m-d'),
                ]);
            }
        }
    }

    /**
     * Generate kode_perusahaan unik 4 digit angka.
     */
    private function generateUniqueKodePerusahaan(): string
    {
        do {
            $kode = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (PerusahaanModel::where('kode_perusahaan', $kode)->exists());

        return $kode;
    }
}
