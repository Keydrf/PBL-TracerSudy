<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\SurveiAlumni; // import model
use App\Models\SurveiAlumniModel;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $tahunAwal = $request->get('tahun_awal', date('Y') - 3);
        $tahunAkhir = $request->get('tahun_akhir', date('Y'));

        // // Data untuk Grafik Sebaran Profesi Lulusan
        // $totalAlumniProfesi = DB::table('survei_alumni')->count();
        // $profesi = DB::table('survei_alumni')
        //     ->join('profesi', 'survei_alumni.profesi_id', '=', 'profesi.profesi_id')
        //     ->select('profesi.nama_profesi', DB::raw('count(*) as jumlah'))
        //     ->groupBy('profesi.nama_profesi')
        //     ->orderBy('jumlah', 'desc')
        //     ->get();
        // Data untuk Grafik Sebaran Profesi Lulusan
        $totalAlumniProfesi = DB::table('survei_alumni')
            ->when($tahunAwal && $tahunAkhir, fn($q) => $q->whereBetween('tahun_lulus', [$tahunAwal, $tahunAkhir]))
            ->count();

        $profesi = DB::table('survei_alumni')
            ->join('profesi', 'survei_alumni.profesi_id', '=', 'profesi.profesi_id')
            ->select('profesi.nama_profesi', DB::raw('count(*) as jumlah'))
            ->when($tahunAwal && $tahunAkhir, fn($q) => $q->whereBetween('survei_alumni.tahun_lulus', [$tahunAwal, $tahunAkhir]))
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
        //filtering
        
         // 1. Tabel Sebaran Lingkup Tempat Kerja
        $lingkupTempatKerjaData = DB::table('survei_alumni')
        ->select(
            'tahun_lulus',
            DB::raw('COUNT(*) as jumlah_lulusan'),
            DB::raw('COUNT(tanggal_pertama_kerja) as jumlah_terlacak'),
            DB::raw('SUM(CASE WHEN p.kategori_id = 1 THEN 1 ELSE 0 END) as profesi_infokom'),
            DB::raw('SUM(CASE WHEN p.kategori_id != 1 THEN 1 ELSE 0 END) as profesi_non_infokom'),
            DB::raw('SUM(CASE WHEN skala = "Multinasional/Internasional" THEN 1 ELSE 0 END) as multinasional'),
            DB::raw('SUM(CASE WHEN skala = "Nasional" THEN 1 ELSE 0 END) as nasional'),
            DB::raw('SUM(CASE WHEN skala = "Wirausaha" THEN 1 ELSE 0 END) as wirausaha'),
            DB::raw('SUM(CASE WHEN skala = "Lokal" THEN 1 ELSE 0 END) as lokal')
        )
        ->leftJoin('profesi as p', 'survei_alumni.profesi_id', '=', 'p.profesi_id')
        ->groupBy('tahun_lulus')
        ->orderBy('tahun_lulus')
        ->get();

        $total = [
            'jumlah_lulusan' => $lingkupTempatKerjaData->sum('jumlah_lulusan'),
            'jumlah_terlacak' => $lingkupTempatKerjaData->sum('jumlah_terlacak'),
            'profesi_infokom' => $lingkupTempatKerjaData->sum('profesi_infokom'),
            'profesi_non_infokom' => $lingkupTempatKerjaData->sum('profesi_non_infokom'),
            'multinasional' => $lingkupTempatKerjaData->sum('multinasional'),
            'nasional' => $lingkupTempatKerjaData->sum('nasional'),
            'wirausaha' => $lingkupTempatKerjaData->sum('wirausaha'),
            'lokal' => $lingkupTempatKerjaData->sum('lokal'),
        ];

        // 2. Tabel Rata-rata Masa Tunggu Per Prodi
       $masaTungguData = DB::table('survei_alumni')
        ->select(
            'tahun_lulus',
            DB::raw('COUNT(*) as jumlah_lulusan'),
            DB::raw('COUNT(masa_tunggu) as jumlah_terlacak'),
            DB::raw('AVG(masa_tunggu) as rata_rata_bulan')
        )
        ->groupBy('tahun_lulus')
        ->orderBy('tahun_lulus')
        ->get();

        $totalMasaTunggu = [
            'jumlah_lulusan' => $masaTungguData->sum('jumlah_lulusan'),
            'jumlah_terlacak' => $masaTungguData->sum('jumlah_terlacak'),
            'rata_rata_bulan' => round($masaTungguData->avg('rata_rata_bulan'), 2),
        ];

        // 3. Penilaian Kepuasan Pengguna Lulusan (ambil dari survei_perusahaan)
$columns = [
            'kerjasama', 'keahlian', 'kemampuan_basing',
            'kemampuan_komunikasi', 'pengembangan_diri',
            'kepemimpinan', 'etoskerja'
        ];

        $nilaiKepuasan = [];

        foreach ($columns as $column) {
            $total = DB::table('tracer_study.survei_perusahaan')->whereNotNull($column)->count();

            if ($total == 0) {
                $nilaiKepuasan[$column] = [
                    'sangat_baik' => 0,
                    'baik' => 0,
                    'cukup' => 0,
                    'kurang' => 0,
                ];
                continue;
            }

            $kategori = DB::table('tracer_study.survei_perusahaan')
                ->select(
                    DB::raw("SUM(CASE WHEN $column = 4 THEN 1 ELSE 0 END) as sangat_baik"),
                    DB::raw("SUM(CASE WHEN $column = 3 THEN 1 ELSE 0 END) as baik"),
                    DB::raw("SUM(CASE WHEN $column = 2 THEN 1 ELSE 0 END) as cukup"),
                    DB::raw("SUM(CASE WHEN $column = 1 THEN 1 ELSE 0 END) as kurang")
                )
                ->first();

            $nilaiKepuasan[$column] = [
                'sangat_baik' => round(($kategori->sangat_baik / $total) * 100, 2),
                'baik'        => round(($kategori->baik / $total) * 100, 2),
                'cukup'       => round(($kategori->cukup / $total) * 100, 2),
                'kurang'      => round(($kategori->kurang / $total) * 100, 2),
            ];
        }

        return view('dashboard', [
            'labelsProfesi' => $labelsProfesi,
            'dataProfesi' => $dataProfesi,
            'labelsInstansi' => $labelsInstansi,
            'dataInstansi' => $dataInstansi,
            'dataKepuasan' => $dataKepuasan,
            'kriteriaKepuasan' => $kriteriaKepuasan,
            'lingkupTempatKerjaData' => $lingkupTempatKerjaData,
            'masaTungguData' => $masaTungguData,
            'totalMasaTunggu' => $totalMasaTunggu,
            'nilaiKepuasan' => $nilaiKepuasan
        ]);
    }
}
