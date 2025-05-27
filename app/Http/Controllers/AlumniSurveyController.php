<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail; // Pastikan ini di-import
use Illuminate\Support\Str; // Pastikan ini di-import untuk Str::random()
use App\Mail\CompanyOtpMail;

class AlumniSurveyController extends Controller
{
    public function create()
    {
        $profesiList = DB::table('profesi')->get();
        $kategoriList = DB::table('kategori_profesi')->get();

        return view('surveialumni.survei', compact('profesiList', 'kategoriList'));
    }

    public function store(Request $request)
    {
        // Validasi data request
        $validator = Validator::make($request->all(), [
            'program_studi' => 'required|string|max:100',
            'tahun_lulus' => 'required|integer',
            'nim' => 'required|string|max:10|exists:alumni,nim',
            'kode_otp_alumni' => [ // Diubah dari 'kode_otp' menjadi 'kode_otp_alumni'
                'required',
                'string',
                'max:4',
                function ($attribute, $value, $fail) use ($request) {
                    $alumni = DB::table('alumni')->where('nim', $request->nim)->first();
                    if (!$alumni || $alumni->kode_otp_alumni !== $value) { // Menggunakan kode_otp_alumni dari database
                        $fail('Kode OTP alumni tidak valid untuk alumni yang dipilih.');
                    }
                },
            ],
            'no_telepon' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'tanggal_pertama_kerja' => 'required|date',
            'masa_tunggu' => 'required|integer',
            'tanggal_pertama_kerja_instansi_saat_ini' => 'required|date',
            'jenis_instansi' => 'required|string|max:100',
            'nama_instansi' => 'required|string|max:100',
            'skala' => 'required|string|max:100',
            'lokasi_instansi' => 'required|string|max:255',
            'nama_atasan' => 'required|string|max:100',
            'jabatan_atasan' => 'required|string|max:100',
            'no_telepon_atasan' => 'required|string|max:100',
            'email_atasan' => 'required|email|max:100', // Pastikan ini ada dan divalidasi
            'profesi_id' => 'nullable|exists:profesi,profesi_id',
            'pendapatan' => 'required|integer',
            'alamat_kantor' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'kategori_id' => 'nullable|exists:kategori_profesi,kategori_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Generate kode OTP untuk email perusahaan
            // Ini adalah OTP yang berbeda dari OTP alumni
            $companyOtp = Str::random(4); // Contoh: 4 karakter acak

            // Memasukkan data survei ke database
            DB::insert('INSERT INTO survei_alumni (
                nim, no_telepon, email, tahun_lulus, tanggal_pertama_kerja,
                masa_tunggu, tanggal_pertama_kerja_instansi_saat_ini, jenis_instansi,
                nama_instansi, skala, lokasi_instansi,
                nama_atasan, jabatan_atasan, no_telepon_atasan, email_atasan,
                profesi_id, pendapatan, alamat_kantor, kabupaten, kategori_id,
                kode_otp_alumni, kode_otp_perusahaan, created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [ // Menambahkan satu placeholder untuk kode_otp_perusahaan
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
                $request->nama_atasan,
                $request->jabatan_atasan,
                $request->no_telepon_atasan,
                $request->email_atasan,
                $request->profesi_id,
                $request->pendapatan,
                $request->alamat_kantor,
                $request->kabupaten,
                $request->kategori_id,
                $request->kode_otp_alumni, // Menggunakan kode_otp_alumni dari request
                $companyOtp, // Menambahkan nilai kode_otp_perusahaan
                now(),
                now()
            ]);

            // Kirim OTP ke email atasan (perusahaan)
            // Pastikan 'email_atasan' sudah divalidasi dan ada di request
            if ($request->filled('email_atasan')) {
                Mail::to($request->email_atasan)->send(new CompanyOtpMail($companyOtp));
            }

            return redirect()->back()->with('success', 'Survei berhasil disimpan dan OTP perusahaan telah dikirim.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

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
