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
        $programStudi = $request->get('program_studi', null);

        // Normalisasi dan pengecekan filter "semuanya"
        if (empty($programStudi) || strtolower(trim($programStudi)) === 'semuanya') {
            $programStudi = null;
        }

        // // Data untuk Grafik Sebaran Profesi Alumni
        $totalAlumniProfesi = DB::table('survei_alumni')
            ->join('alumni', 'survei_alumni.nim', '=', 'alumni.nim')
            ->when($tahunAwal && $tahunAkhir, fn($q) => $q->whereBetween('tahun_lulus', [$tahunAwal, $tahunAkhir]))
            ->when($programStudi, fn($q) => $q->where('alumni.program_studi', $programStudi))
            ->count();

        // Ambil semua kategori profesi
        $allProfesi = DB::table('profesi')->pluck('nama_profesi')->toArray();

        $profesi = DB::table('survei_alumni')
            ->join('profesi', 'survei_alumni.profesi_id', '=', 'profesi.profesi_id')
            ->select('profesi.nama_profesi', DB::raw('count(*) as jumlah'))
            ->join('alumni', 'survei_alumni.nim', '=', 'alumni.nim')
            ->when($tahunAwal && $tahunAkhir, fn($q) => $q->whereBetween('survei_alumni.tahun_lulus', [$tahunAwal, $tahunAkhir]))
            ->when($programStudi, fn($q) => $q->where('alumni.program_studi', $programStudi))
            ->groupBy('profesi.nama_profesi')
            ->orderBy('jumlah', 'desc')
            ->get();

        // Buat mapping nama_profesi => jumlah
        $profesiMap = [];
        foreach ($profesi as $item) {
            $profesiMap[$item->nama_profesi] = $item->jumlah;
        }

        $labelsProfesi = [];
        $dataProfesi = [];
        $lainnyaCountProfesi = 0;
        $topCountProfesi = 0;
        $maxTopProfesi = 10;

        // Pastikan semua kategori profesi tetap muncul (meskipun 0)
        foreach ($allProfesi as $namaProfesi) {
            if ($topCountProfesi < $maxTopProfesi) {
                $labelsProfesi[] = $namaProfesi;
                $dataProfesi[] = $profesiMap[$namaProfesi] ?? 0;
                $topCountProfesi++;
            } else {
                $lainnyaCountProfesi += $profesiMap[$namaProfesi] ?? 0;
            }
        }

        if ($lainnyaCountProfesi > 0) {
            $labelsProfesi[] = 'Lainnya';
            $dataProfesi[] = $lainnyaCountProfesi;
        }

        // Data untuk Grafik Sebaran Jenis Instansi
        $jenisInstansiData = DB::table('survei_alumni')
            ->join('alumni', 'survei_alumni.nim', '=', 'alumni.nim')
            ->when($tahunAwal && $tahunAkhir, fn($q) => $q->whereBetween('tahun_lulus', [$tahunAwal, $tahunAkhir]))
            ->when($programStudi, fn($q) => $q->where('alumni.program_studi', $programStudi))
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

        // Data untuk Grafik Penilaian Kepuasan Pengguna Alumni
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
                ->join('survei_alumni', 'survei_perusahaan.nim', '=', 'survei_alumni.nim')
                ->join('alumni', 'survei_alumni.nim', '=', 'alumni.nim')
                ->when($tahunAwal && $tahunAkhir, fn($q) => $q->whereBetween('survei_alumni.tahun_lulus', [$tahunAwal, $tahunAkhir]))
                ->when($programStudi, fn($q) => $q->where('alumni.program_studi', $programStudi))
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
        
         // 1. Tabel Sebaran Lingkup Tempat Kerja
        $lingkupTempatKerjaData = DB::table('survei_alumni')
        ->join('alumni', 'survei_alumni.nim', '=', 'alumni.nim')
        ->when($tahunAwal && $tahunAkhir, fn($q) => $q->whereBetween('tahun_lulus', [$tahunAwal, $tahunAkhir]))
        ->when($programStudi, fn($q) => $q->where('alumni.program_studi', $programStudi))
        ->select(
            'tahun_lulus',
            DB::raw('COUNT(*) as jumlah_alumni'),
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
            'jumlah_alumni' => $lingkupTempatKerjaData->sum('jumlah_alumni'),
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
        ->join('alumni', 'survei_alumni.nim', '=', 'alumni.nim')
        ->when($tahunAwal && $tahunAkhir, fn($q) => $q->whereBetween('tahun_lulus', [$tahunAwal, $tahunAkhir]))
        ->when($programStudi, fn($q) => $q->where('alumni.program_studi', $programStudi))
        ->select(
            'tahun_lulus',
            DB::raw('COUNT(*) as jumlah_alumni'),
            DB::raw('COUNT(masa_tunggu) as jumlah_terlacak'),
            DB::raw('AVG(masa_tunggu) as rata_rata_bulan')
        )
        ->groupBy('tahun_lulus')
        ->orderBy('tahun_lulus')
        ->get();

        $totalMasaTunggu = [
            'jumlah_alumni' => $masaTungguData->sum('jumlah_alumni'),
            'jumlah_terlacak' => $masaTungguData->sum('jumlah_terlacak'),
            'rata_rata_bulan' => round($masaTungguData->avg('rata_rata_bulan'), 2),
        ];

        // 3. Penilaian Kepuasan Pengguna Alumni (ambil dari survei_perusahaan)
        $nilaiKepuasan = [];

        $columns = [
            'kerjasama', 'keahlian', 'kemampuan_basing',
            'kemampuan_komunikasi', 'pengembangan_diri',
            'kepemimpinan', 'etoskerja'
        ];

        foreach ($columns as $column) {
            $query = DB::table('tracer_study.survei_perusahaan')
                ->join('survei_alumni', 'survei_perusahaan.nim', '=', 'survei_alumni.nim')
                ->join('alumni', 'survei_alumni.nim', '=', 'alumni.nim')
                ->when($tahunAwal && $tahunAkhir, fn($q) => $q->whereBetween('survei_alumni.tahun_lulus', [$tahunAwal, $tahunAkhir]))
                ->when($programStudi, fn($q) => $q->where('alumni.program_studi', $programStudi))
                ->whereNotNull($column);

            $total = $query->count();

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
                ->join('survei_alumni', 'survei_perusahaan.nim', '=', 'survei_alumni.nim')
                ->join('alumni', 'survei_alumni.nim', '=', 'alumni.nim')
                ->when($tahunAwal && $tahunAkhir, fn($q) => $q->whereBetween('survei_alumni.tahun_lulus', [$tahunAwal, $tahunAkhir]))
                ->when($programStudi, fn($q) => $q->where('alumni.program_studi', $programStudi))
                ->select(
                    DB::raw("SUM(CASE WHEN $column = 'sangat baik' THEN 1 ELSE 0 END) as sangat_baik"),
                    DB::raw("SUM(CASE WHEN $column = 'baik' THEN 1 ELSE 0 END) as baik"),
                    DB::raw("SUM(CASE WHEN $column = 'cukup' THEN 1 ELSE 0 END) as cukup"),
                    DB::raw("SUM(CASE WHEN $column = 'kurang' THEN 1 ELSE 0 END) as kurang")
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
