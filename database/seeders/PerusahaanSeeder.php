<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SurveiAlumniModel;
use App\Models\PerusahaanModel;
use App\Models\AlumniModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PerusahaanSeeder extends Seeder
{
    public function run(): void
    {
        DB::beginTransaction();

        try {
            $surveiAlumnis = SurveiAlumniModel::all();

            foreach ($surveiAlumnis as $survei) {
                if (PerusahaanModel::where('survei_alumni_id', $survei->survei_alumni_id)->exists()) {
                    continue;
                }

                $alumni = AlumniModel::where('nim', $survei->nim)->first();

                PerusahaanModel::create([
                    'survei_alumni_id' => $survei->survei_alumni_id,
                    'kode_perusahaan'  => $this->generateUniqueKodePerusahaan(),
                    'nama_atasan'      => $survei->nama_atasan ?? 'Atasan Default',
                    'instansi'         => $survei->jenis_instansi ?? 'Tidak Diketahui',
                    'nama_instansi'    => $survei->nama_instansi ?? 'Tidak Diketahui',
                    'no_telepon'       => $survei->no_telepon ?? '000000000',
                    'email'            => $survei->email ?? 'email@default.com',
                    'nama_alumni'      => $alumni->nama ?? 'Alumni Tidak Dikenal',
                    'program_studi'    => $alumni->program_studi ?? 'Program Studi Tidak Diketahui',
                    'tanggal_lulus'      => $alumni->tanggal_lulus ?? now(), // Langsung ambil tanggal lulus, default ke sekarang jika null
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in PerusahaanSeeder: ' . $e->getMessage());
            $this->command->error('Error seeding perusahaan data: ' . $e->getMessage());
        }
    }

    private function generateUniqueKodePerusahaan(): string
    {
        do {
            $kode = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (PerusahaanModel::where('kode_perusahaan', $kode)->exists());

        return $kode;
    }
}
