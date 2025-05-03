<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

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

        return view('dashboard', [
            'labelsProfesi' => $labelsProfesi,
            'dataProfesi' => $dataProfesi,
            'labelsInstansi' => $labelsInstansi,
            'dataInstansi' => $dataInstansi,
            'dataKepuasan' => $dataKepuasan,
            'kriteriaKepuasan' => $kriteriaKepuasan,
        ]);
    }
}
