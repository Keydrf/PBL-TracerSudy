<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\SurveiAlumni; // import model
use App\Models\SurveiAlumniModel;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Data untuk Grafik Sebaran Profesi Lulusan
        $totalAlumniProfesi = DB::table('survei_alumni')->count();
        $profesi = DB::table('survei_alumni')
            ->join('profesi', 'survei_alumni.profesi_id', '=', 'profesi.profesi_id')
            ->select('profesi.nama_profesi', DB::raw('count(*) as jumlah'))
            ->groupBy('profesi.nama_profesi')
            ->orderBy('jumlah', 'desc')
            ->get();

        $labelsProfesi = [];
        $dataProfesi = [];
        $lainnyaCountProfesi = 0;
        $topCountProfesi = 0;
        $maxTopProfesi = 10;

        foreach ($profesi as $item) {
            if ($topCountProfesi < $maxTopProfesi) {
                $labelsProfesi[] = $item->nama_profesi;
                $dataProfesi[] = $item->jumlah;
                $topCountProfesi++;
            } else {
                $lainnyaCountProfesi += $item->jumlah;
            }
        }

        if ($lainnyaCountProfesi > 0) {
            $labelsProfesi[] = 'Lainnya';
            $dataProfesi[] = $lainnyaCountProfesi;
        }

        // Data untuk Grafik Sebaran Jenis Instansi
        $jenisInstansiData = DB::table('survei_alumni')
            ->select('jenis_instansi', DB::raw('count(*) as jumlah'))
            ->groupBy('jenis_instansi')
            ->pluck('jumlah', 'jenis_instansi')
            ->toArray();

        $labelsInstansi = ['Pendidikan Tinggi', 'Instansi Pemerintah', 'Perusahaan Swasta', 'BUMN'];
        $dataInstansi = [
            $jenisInstansiData['Pendidikan Tinggi'] ?? 0,
            $jenisInstansiData['Instansi Pemerintah'] ?? 0,
            $jenisInstansiData['Perusahaan Swasta'] ?? 0,
            $jenisInstansiData['BUMN'] ?? 0,
        ];

        // Data untuk Grafik Penilaian Kepuasan Pengguna Lulusan
        $kriteriaKepuasan = [
            'kerjasama',
            'keahlian',
            'kemampuan_basing',
            'kemampuan_komunikasi',
            'pengembangan_diri',
            'kepemimpinan',
            'etoskerja',
        ];

        $kepuasanLabels = ['kurang', 'cukup', 'baik', 'sangat baik']; // Define labels
        $dataKepuasan = [];
        foreach ($kriteriaKepuasan as $kriteria) {
            $kepuasanData = DB::table('survei_perusahaan')
                ->select($kriteria, DB::raw('count(*) as jumlah'))
                ->groupBy($kriteria)
                ->orderByRaw(sprintf("FIELD(%s, '%s')", $kriteria, implode("','", $kepuasanLabels))) // Order
                ->pluck('jumlah', $kriteria)
                ->toArray();

             // Ensure all kepuasan levels are present with counts, default to 0 if missing
            $seriesKepuasan = [];
            foreach ($kepuasanLabels as $label) {
                $seriesKepuasan[] = $kepuasanData[$label] ?? 0;
            }

            $dataKepuasan[$kriteria] = [
                'labels' => $kepuasanLabels,
                'series' => $seriesKepuasan,
            ];
        }
         // 1. Sebaran Lingkup Tempat Kerja & Kesesuaian Profesi
        $lingkupTempatKerjaData = SurveiAlumniModel::select(
                'lokasi_instansi as lingkup_tempat_kerja',
                DB::raw('COUNT(*) as jumlah'),
                DB::raw('SUM(CASE WHEN kategori_id IS NOT NULL THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as kesesuaian_infokom')
            )
            ->groupBy('lokasi_instansi')
            ->get();

        // 2. Rata-rata Masa Tunggu Per Prodi
        $masaTungguData = DB::table('tracer_study.survei_alumni')
            ->join('tracer_study.alumni', 'survei_alumni.survei_alumni_id', '=', 'alumni.alumni_id')
            ->select(
                'alumni.program_studi',
                DB::raw('AVG(survei_alumni.masa_tunggu) as rata_rata_bulan')
            )
            ->groupBy('alumni.program_studi')
            ->get();

        // 3. Penilaian Kepuasan Pengguna Lulusan (ambil dari survei_perusahaan)
        $kepuasan = DB::table('tracer_study.survei_perusahaan')
            ->select([
                DB::raw('AVG(kerjasama) as kerjasama'),
                DB::raw('AVG(keahlian) as keahlian'),
                DB::raw('AVG(kemampuan_basing) as kemampuan_basing'),
                DB::raw('AVG(kemampuan_komunikasi) as komunikasi'),
                DB::raw('AVG(pengembangan_diri) as pengembangan'),
                DB::raw('AVG(kepemimpinan) as kepemimpinan'),
                DB::raw('AVG(etoskerja) as etoskerja')
            ])
            ->first();

        $nilaiKepuasan = [
            'kerjasama' => ['rata_rata' => $kepuasan->kerjasama, 'keterangan' => ''],
            'keahlian' => ['rata_rata' => $kepuasan->keahlian, 'keterangan' => ''],
            'kemampuan_basing' => ['rata_rata' => $kepuasan->kemampuan_basing, 'keterangan' => ''],
            'komunikasi' => ['rata_rata' => $kepuasan->komunikasi, 'keterangan' => ''],
            'pengembangan_diri' => ['rata_rata' => $kepuasan->pengembangan, 'keterangan' => ''],
            'kepemimpinan' => ['rata_rata' => $kepuasan->kepemimpinan, 'keterangan' => ''],
            'etoskerja' => ['rata_rata' => $kepuasan->etoskerja, 'keterangan' => ''],
        ];

        return view('dashboard', [
            'labelsProfesi' => $labelsProfesi,
            'dataProfesi' => $dataProfesi,
            'labelsInstansi' => $labelsInstansi,
            'dataInstansi' => $dataInstansi,
            'dataKepuasan' => $dataKepuasan,
            'kriteriaKepuasan' => $kriteriaKepuasan,
            'lingkupTempatKerjaData' => $lingkupTempatKerjaData,
            'masaTungguData' => $masaTungguData,
            'nilaiKepuasan' => $nilaiKepuasan,
        ]);
    }
}
