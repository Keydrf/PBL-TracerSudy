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
        $perusahaanList = PerusahaanModel::with(['surveiAlumni.alumni'])->get();
        $totalAlumni = AlumniModel::count();
        $totalSurveiAlumni = SurveiAlumniModel::count();
        $totalProfesi = ProfesiModel::count();
        $totalPerusahaan = PerusahaanModel::count();

        return view('landingpage', compact('totalAlumni', 'totalSurveiAlumni', 'totalProfesi', 'totalPerusahaan', 'perusahaanList'));
    }
}
