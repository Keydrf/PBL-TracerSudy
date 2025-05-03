<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AlumniSurveyController extends Controller
{
    public function create()
    {
        return view('surveialumni.survei');
    }
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'program_studi' => 'required|string|max:100',
            'tahun_lulus' => 'required|integer',
            'nim' => 'required|string|max:10|exists:alumni,nim',
            'no_telepon' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'tanggal_pertama_kerja' => 'required|date',
            'masa_tunggu' => 'required|integer',
            'tanggal_pertama_kerja_instansi_saat_ini' => 'required|date',
            'jenis_instansi' => 'required|string|max:100',
            'nama_instansi' => 'required|string|max:100',
            'skala' => 'required|string|max:100',
            'lokasi_instansi' => 'required|string|max:255',
            'kategori_profesi' => 'required|string|max:100',
            'profesi' => 'required|string|max:100',
            'nama_atasan' => 'required|string|max:100',
            'jabatan_atasan' => 'required|string|max:100',
            'no_telepon_atasan' => 'required|string|max:100',
            'email_atasan' => 'required|email|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Using raw query as requested (no framework/ORM)
            DB::insert('INSERT INTO survei_alumni (
                nim, no_telepon, email, tahun_lulus, tanggal_pertama_kerja, 
                masa_tunggu, tanggal_pertama_kerja_instansi_saat_ini, jenis_instansi, 
                nama_instansi, skala, lokasi_instansi, kategori_profesi, profesi, 
                nama_atasan, jabatan_atasan, no_telepon_atasan, email_atasan, 
                created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->nim,
                $request->no_telepon,
                $request->email,
                $request->tahun_lulus,
                $request->tanggal_pertama_kerja,
                $request->masa_tunggu,
                $request->tanggal_pertama_kerja_instansi_saat_ini,
                $request->jenis_instansi,
                $request->nama_instansi,
                $request->skala,
                $request->lokasi_instansi,
                $request->kategori_profesi,
                $request->profesi,
                $request->nama_atasan,
                $request->jabatan_atasan,
                $request->no_telepon_atasan,
                $request->email_atasan,
                now(),
                now()
            ]);

            return view('surveialumni.survei');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Search for alumni by NIM or name.
     */
    public function search(Request $request)
    {
        $term = $request->input('term');

        if (strlen($term) < 3) {
            return response()->json([]);
        }

        $results = DB::select("
        SELECT nim, nama, program_studi, YEAR(tanggal_lulus) as tahun_lulus 
        FROM alumni 
        WHERE nim LIKE ? OR nama LIKE ? 
        ORDER BY nama ASC 
        LIMIT 10
    ", ["%{$term}%", "%{$term}%"]);

        return response()->json($results);
    }
}
