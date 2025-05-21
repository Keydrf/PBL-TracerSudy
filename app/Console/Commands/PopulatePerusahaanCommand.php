<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PerusahaanModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PopulatePerusahaanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:perusahaan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate data perusahaan dari survei alumni';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Contoh ambil data survei alumni (ganti dengan query sesuai kebutuhanmu)
        $dataSurvei = DB::table('survei_alumni')
            ->select(
                'survei_alumni_id',
                'nama_atasan',
                'instansi',
                'nama_instansi',
                'no_telepon',
                'email',
                'nama_alumni',
                'program_studi',
                'tahun_lulus'
            )
            ->get();

        foreach ($dataSurvei as $data) {
            $perusahaan = PerusahaanModel::where('survei_alumni_id', $data->survei_alumni_id)->first();

            if ($perusahaan) {
                // Update data jika sudah ada
                $perusahaan->update([
                    'nama_atasan'   => $data->nama_atasan,
                    'instansi'      => $data->instansi,
                    'nama_instansi' => $data->nama_instansi,
                    'no_telepon'    => $data->no_telepon,
                    'email'         => $data->email,
                    'nama_alumni'   => $data->nama_alumni,
                    'program_studi' => $data->program_studi,
                    'tahun_lulus'   => $data->tahun_lulus,
                ]);
            } else {
                // Buat data baru dengan kode_perusahaan unik 4 digit
                PerusahaanModel::create([
                    'survei_alumni_id' => $data->survei_alumni_id,
                    'kode_perusahaan'  => $this->generateUniqueKodePerusahaan(),
                    'nama_atasan'      => $data->nama_atasan,
                    'instansi'         => $data->instansi,
                    'nama_instansi'    => $data->nama_instansi,
                    'no_telepon'       => $data->no_telepon,
                    'email'            => $data->email,
                    'nama_alumni'      => $data->nama_alumni,
                    'program_studi'    => $data->program_studi,
                    'tahun_lulus'      => $data->tahun_lulus,
                ]);
            }
        }

        $this->info('Data perusahaan berhasil diproses.');
    }

    /**
     * Generate kode perusahaan unik 4 digit (angka).
     */
    protected function generateUniqueKodePerusahaan()
    {
        do {
            $kode = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

            $exists = PerusahaanModel::where('kode_perusahaan', $kode)->exists();
        } while ($exists);

        return $kode;
    }
}
