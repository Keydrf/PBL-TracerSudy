<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\SurveiAlumniModel;
use Carbon\Carbon;

class PerusahaanSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua data dari tabel survei_alumni
        $surveiAlumnis = SurveiAlumniModel::all();

        foreach ($surveiAlumnis as $alumni) {
            DB::table('perusahaan')->insert([
                'survei_alumni_id' => $alumni->survei_alumni_id, // gunakan 'id' jika itu primary key
                'nama_atasan'      => $alumni->nama_atasan ?? 'Atasan Default',
                'instansi'         => $alumni->jenis_instansi ?? 'Tidak Diketahui',
                'nama_instansi'    => $alumni->nama_instansi ?? 'Tidak Diketahui',
                'no_telepon'       => $alumni->no_telepon ?? '000000000',
                'email'            => $alumni->email ?? 'email@default.com',
                'nama_alumni'      => $alumni->nama_alumni ?? 'Alumni Tidak Dikenal',
                'program_studi'    => $alumni->program_studi ?? 'Program Studi Tidak Diketahui',
                'tahun_lulus'      => Carbon::now()->subYears(rand(1, 5))->format('Y-m-d'),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }
}
