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
        $dataSurvei = DB::table('survei_alumni as s')
            ->leftJoin('alumni as a', 's.nim', '=', 'a.nim')
            ->select(
                's.survei_alumni_id',
                's.nama_atasan',
                's.jenis_instansi',
                's.nama_instansi',
                's.no_telepon',
                's.email',
                'a.nama as nama_alumni',          // Ambil dari tabel alumni
                'a.program_studi',                // Ambil dari tabel alumni
                // 'a.program_studi',
                DB::raw('YEAR(a.tanggal_lulus) as tanggal_lulus')                  // Ambil dari tabel alumni
            )
            ->get();


        foreach ($dataSurvei as $data) {
            $perusahaan = PerusahaanModel::where('survei_alumni_id', $data->survei_alumni_id)->first();

            if ($perusahaan) {
                // Update data jika sudah ada
                $perusahaan->update([
                    'nama_atasan'   => $data->nama_atasan,
                    'instansi'      => $data->jenis_instansi,
                    'nama_instansi' => $data->nama_instansi,
                    'no_telepon'    => $data->no_telepon,
                    'email'         => $data->email,
                    'nama_alumni'   => $data->nama_alumni,
                    'program_studi' => $data->program_studi,
                    'tanggal_lulus'   => $data->tanggal_lulus,
                ]);
            } else {
                // Buat data baru dengan kode_perusahaan unik 4 digit
                PerusahaanModel::create([
                    'survei_alumni_id' => $data->survei_alumni_id,
                    'kode_perusahaan'  => $this->generateUniqueKodePerusahaan(),
                    'nama_atasan'      => $data->nama_atasan,
                    'instansi'         => $data->jenis_instansi,
                    'nama_instansi'    => $data->nama_instansi,
                    'no_telepon'       => $data->no_telepon,
                    'email'            => $data->email,
                    'nama_alumni'      => $data->nama_alumni,
                    'program_studi'    => $data->program_studi,
                    'tanggal_lulus'      => $data->tanggal_lulus,
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
