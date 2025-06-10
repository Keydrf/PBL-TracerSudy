<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AlumniBelumIsiSurveiExport;
use App\Exports\PenggunaAlumniBelumIsiSurveiExport;
use App\Exports\SurveyPenggunaLulusanExport;
use App\Exports\TracerStudyLulusanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $reports = [
            [
                'title' => __('laporan.table.reports.tracer_study'),
                'url' => '/laporan/tracer-study'
            ],
            [
                'title' => __('laporan.table.reports.satisfaction_survey'),
                'url' => '/laporan/survei-kepuasan'
            ],
            [
                'title' => __('laporan.table.reports.unfilled_tracer'),
                'url' => '/laporan/belum-tracer'
            ],
            [
                'title' => __('laporan.table.reports.unfilled_survey'),
                'url' => '/laporan/belum-survei'
            ]
        ];

        return view('laporan.index', compact('reports'));
    }

    public function tracerStudy(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $fileName = __('laporan.table.reports.tracer_study') . '.xlsx';

        return Excel::download(
            new TracerStudyLulusanExport($startDate, $endDate),
            $fileName
        );
    }

    public function belumTracer(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $fileName = __('laporan.table.reports.unfilled_tracer') . '.xlsx';

        return Excel::download(
            new AlumniBelumIsiSurveiExport($startDate, $endDate),
            $fileName
        );
    }

    public function belumSurvei(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $fileName = __('laporan.table.reports.unfilled_survey') . '.xlsx';

        return Excel::download(
            new PenggunaAlumniBelumIsiSurveiExport($startDate, $endDate),
            $fileName
        );
    }

    public function surveiKepuasan(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $fileName = __('laporan.table.reports.satisfaction_survey') . '.xlsx';

        return Excel::download(
            new SurveyPenggunaLulusanExport($startDate, $endDate),
            $fileName
        );
    }
}
