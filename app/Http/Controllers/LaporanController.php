<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AlumniBelumIsiSurveiExport;
use App\Exports\PenggunaAlumniBelumIsiSurveiExport;
use App\Exports\TracerStudyLulusanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function belumTracer()
    {
        return Excel::download(new AlumniBelumIsiSurveiExport, 'Rekap Alumni Belum Isi TS.xlsx');
    }

    public function belumSurvei() 
    {
        return Excel::download(new PenggunaAlumniBelumIsiSurveiExport, 'Rekap Pengguna Lulusan Belum Isi Survey.xlsx');
    }

    public function tracerStudy()
    {
        return Excel::download(new TracerStudyLulusanExport, 'Rekap Tracer Studi Lulusan.xlsx');
    }
}
