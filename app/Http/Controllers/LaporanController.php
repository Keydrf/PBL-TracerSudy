<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AlumniBelumIsiSurveiExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function tracerStudy()
    {
        return Excel::download(new AlumniBelumIsiSurveiExport, 'alumni-belum-isi-survei.xlsx');
    }
}
