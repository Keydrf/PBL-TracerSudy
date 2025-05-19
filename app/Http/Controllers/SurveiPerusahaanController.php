<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SurveiPerusahaanController extends Controller
{
    public function create()
    {
        // Updated to return nama_instansi for better searchability
        $perusahaanList = DB::table('perusahaan')
            ->select('perusahaan_id', 'nama_instansi')
            ->get();
        return view('surveiperusahaan.survei', compact('perusahaanList'));
    }

    /**
     * Store the survey data.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'instansi' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'no_telepon' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'nim' => 'required|string|max:10|exists:alumni,nim',
            'kerjasama' => 'required|string|max:255',
            'keahlian' => 'required|string|max:255',
            'kemampuan_basing' => 'required|string|max:255',
            'kemampuan_komunikasi' => 'required|string|max:255',
            'pengembangan_diri' => 'required|string|max:255',
            'kepemimpinan' => 'required|string|max:255',
            'etoskerja' => 'required|string|max:255',
            'kompetensi_yang_belum_dipenuhi' => 'required|string|max:255',
            'saran' => 'required|string|max:255',
            'perusahaan_id' => 'required|exists:perusahaan,perusahaan_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Simpan data survei perusahaan
            DB::insert('INSERT INTO survei_perusahaan (
            nama, instansi, jabatan, no_telepon, email, nim,
            kerjasama, keahlian, kemampuan_basing, kemampuan_komunikasi,
            pengembangan_diri, kepemimpinan, etoskerja, kompetensi_yang_belum_dipenuhi, saran,
            perusahaan_id, created_at, updated_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->nama,
                $request->instansi,
                $request->jabatan,
                $request->no_telepon,
                $request->email,
                $request->nim,
                $request->kerjasama,
                $request->keahlian,
                $request->kemampuan_basing,
                $request->kemampuan_komunikasi,
                $request->pengembangan_diri,
                $request->kepemimpinan,
                $request->etoskerja,
                $request->kompetensi_yang_belum_dipenuhi,
                $request->saran,
                $request->perusahaan_id,
                now(),
                now()
            ]);

            return redirect()->back()->with('success', 'Data survei berhasil disimpan! Terima kasih.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Search for alumni by name.
     */
    public function searchAlumni(Request $request)
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

    /**
     * Get company data for autofill
     */
    public function getPerusahaanData($perusahaan_id)
    {
        // Fetch all details from the perusahaan table
        $perusahaan = DB::table('perusahaan')
            ->where('perusahaan_id', $perusahaan_id)
            ->first();

        if ($perusahaan) {
            // Map to expected field names for the form
            return response()->json([
                'success' => true,
                'data' => $perusahaan
            ]);
        }

        return response()->json(['success' => false]);
    }
}