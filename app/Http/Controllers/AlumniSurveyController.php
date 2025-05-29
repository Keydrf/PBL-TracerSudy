<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompanyOtpMail;

class AlumniSurveyController extends Controller
{
    public function create()
    {
        $profesiList = DB::table('profesi')->select('profesi_id', 'nama_profesi')->get();
        $kategoriList = DB::table('kategori_profesi')->select('kategori_id', 'nama_kategori')->get();

        return view('surveialumni.survei', compact('profesiList', 'kategoriList'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|string|max:10|exists:alumni,nim',
            'kode_otp_alumni' => [
                'required',
                'string',
                'max:4',
                function ($attribute, $value, $fail) use ($request) {
                    $alumni = DB::table('alumni')->where('nim', $request->nim)->first();
                    if (!$alumni || $alumni->kode_otp_alumni !== $value) {
                        $fail('Kode OTP alumni tidak valid untuk alumni yang dipilih.');
                    }
                },
            ],
            'no_telepon' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'tanggal_pertama_kerja' => 'required|date',
            'masa_tunggu' => 'required|integer|min:0',
            'tanggal_pertama_kerja_instansi_saat_ini' => 'required|date|after_or_equal:tanggal_pertama_kerja',
            'jenis_instansi' => 'required|string|max:100',
            'nama_instansi' => 'required|string|max:100',
            'skala' => 'required|string|max:100',
            'lokasi_instansi' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_profesi,kategori_id',
            'profesi_id' => 'required|exists:profesi,profesi_id',
            'nama_atasan' => 'required|string|max:100',
            'jabatan_atasan' => 'required|string|max:100',
            'no_telepon_atasan' => 'required|string|max:100',
            'email_atasan' => 'required|email|max:100',
            'pendapatan' => 'required|integer|min:0',
            'alamat_kantor' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $sudahIsi = DB::table('survei_alumni')->where('nim', $request->nim)->exists();
            if ($sudahIsi) {
                return redirect()->back()->withInput()
                    ->withErrors(['nim' => 'Anda sudah mengisi survei ini sebelumnya.']);
            }

            // Generate kode OTP perusahaan
            $namaAtasanParts = explode(' ', $request->nama_atasan);
            $inisial = strtoupper(substr($namaAtasanParts[0], 0, 1));
            if (count($namaAtasanParts) > 1) {
                $inisial .= strtoupper(substr(end($namaAtasanParts), 0, 1));
            }
            $nim_suffix = substr($request->nim, -2);
            $companyOtp = $inisial . $nim_suffix;

            $tahunLulus = $request->tahun_lulus ?? DB::table('alumni')
                ->where('nim', $request->nim)
                ->value(DB::raw('YEAR(tanggal_lulus)'));

            DB::table('survei_alumni')->insert([
                'nim' => $request->nim,
                'kode_otp_alumni' => $request->kode_otp_alumni,
                'tahun_lulus' => $tahunLulus,
                'no_telepon' => $request->no_telepon,
                'email' => $request->email,
                'tanggal_pertama_kerja' => $request->tanggal_pertama_kerja,
                'masa_tunggu' => $request->masa_tunggu,
                'tanggal_pertama_kerja_instansi_saat_ini' => $request->tanggal_pertama_kerja_instansi_saat_ini,
                'jenis_instansi' => $request->jenis_instansi,
                'nama_instansi' => $request->nama_instansi,
                'skala' => $request->skala,
                'lokasi_instansi' => $request->lokasi_instansi,
                'kategori_id' => $request->kategori_id,
                'profesi_id' => $request->profesi_id,
                'nama_atasan' => $request->nama_atasan,
                'jabatan_atasan' => $request->jabatan_atasan,
                'no_telepon_atasan' => $request->no_telepon_atasan,
                'email_atasan' => $request->email_atasan,
                'pendapatan' => $request->pendapatan,
                'alamat_kantor' => $request->alamat_kantor,
                'kabupaten' => $request->kabupaten,
                'kode_otp_perusahaan' => $companyOtp,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Kirim OTP ke email atasan (perusahaan) menggunakan Mailable class
            if ($request->filled('email_atasan')) {
                try {
                    // Samakan cara pengiriman dengan OTP alumni: tanpa set header tambahan, cukup gunakan Mailable
                    Mail::to($request->email_atasan)->send(new CompanyOtpMail($companyOtp));
                } catch (\Exception $e) {
                    // Email gagal dikirim, log jika perlu
                }
            }

            // Tambahkan kode berikut untuk pop up loading di sisi client (lihat survei.blade.php)
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

        $results = DB::table('alumni')
            ->select('nim', 'nama', 'program_studi', DB::raw('YEAR(tanggal_lulus) as tahun_lulus'))
            ->where('nim', 'LIKE', "%{$term}%")
            ->orWhere('nama', 'LIKE', "%{$term}%")
            ->orderBy('nama', 'ASC')
            ->limit(10)
            ->get();

        return response()->json($results);
    }
}
