<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlumniModel;
use App\Models\ProfesiModel;
use App\Models\SurveiAlumniModel;
use App\Models\PerusahaanModel;




class LandingController extends Controller
{

    public function index()
    {
        $perusahaanList = SurveiAlumniModel::with('alumni')
            ->whereNotNull('nama_instansi')
            ->distinct('nama_instansi')
            ->get();

        $totalAlumni = AlumniModel::count();
        $totalSurveiAlumni = SurveiAlumniModel::count();
        $totalProfesi = ProfesiModel::count();

        // Jumlah perusahaan unik berdasarkan nama_instansi
        $totalPerusahaan = SurveiAlumniModel::whereNotNull('nama_instansi')->distinct('nama_instansi')->count('nama_instansi');

        return view('landingpage', compact('totalAlumni', 'totalSurveiAlumni', 'totalProfesi', 'totalPerusahaan', 'perusahaanList'));
    }
}
