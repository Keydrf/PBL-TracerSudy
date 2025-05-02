<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlumniModel;
use Illuminate\Support\Facades\DB;

class AlumniDataController extends Controller
{
    // Mengambil data alumni berdasarkan prodi
    public function getAlumniData()
    {
        $prodiData = AlumniModel::select('prodi', \DB::raw('count(*) as total'))
                               ->groupBy('prodi')
                               ->get();

        $kategoriProfesiData = AlumniModel::select('kategori_profesi', \DB::raw('count(*) as total'))
                                        ->groupBy('kategori_profesi')
                                        ->get();

        $profesiKategoriData = AlumniModel::select('profesi', \DB::raw('count(*) as total'))
                                        ->groupBy('profesi')
                                        ->get();

        return response()->json([
            'prodiLabels' => $prodiData->pluck('prodi'),
            'prodiSeries' => $prodiData->pluck('total'),
            'kategoriProfesiLabels' => $kategoriProfesiData->pluck('kategori_profesi'),
            'kategoriProfesiSeries' => $kategoriProfesiData->pluck('total'),
            'profesiKategoriLabels' => $profesiKategoriData->pluck('profesi'),
            'profesiKategoriSeries' => $profesiKategoriData->pluck('total')
        ]);
    }
}
