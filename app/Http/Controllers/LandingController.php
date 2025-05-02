<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlumniModel;
use App\Models\ProfesiModel;
use App\Models\SurveiAlumniModel;

class LandingController extends Controller
{
    public function index()
    {
        $totalAlumni = AlumniModel::count();
        // $totalTracer = Tracer::whereNotNull('submitted_at')->count();
        $totalProfesi = ProfesiModel::count();
        // $totalPengguna = User::count();

        return view('landingpage', compact('totalAlumni', 'totalProfesi'));
    }
}
