<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompanyOtpMail;

class AlumniSurveyController extends Controller
{
    public function verificationForm()
    {
        return view('surveialumni.verifikasi');
    }

    public function verify(Request $request)
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if alumni already filled the survey
        $sudahIsi = DB::table('survei_alumni')->where('nim', $request->nim)->exists();
        if ($sudahIsi) {
            return redirect()->back()->withInput()
                ->withErrors(['nim' => 'Anda sudah mengisi survei ini sebelumnya.']);
        }

        // Get alumni data
        $alumni = DB::table('alumni')
            ->select('nim', 'nama', 'program_studi', DB::raw('YEAR(tanggal_lulus) as tahun_lulus'))
            ->where('nim', $request->nim)
            ->first();

        // Store verified alumni data in session
        session([
            'verified_alumni' => [
                'nim' => $alumni->nim,
                'nama' => $alumni->nama,
                'program_studi' => $alumni->program_studi,
                'tahun_lulus' => $alumni->tahun_lulus,
                'kode_otp_alumni' => $request->kode_otp_alumni
            ]
        ]);

        return redirect()->route('alumni.survey.form')->with('success', 'Verifikasi berhasil! Silakan lengkapi survei di bawah ini.');
    }

    public function create()
    {
        // Check if user has been verified
        if (!session('verified_alumni')) {
            return redirect()->route('alumni.survey.verification')
                ->with('error', 'Silakan verifikasi identitas Anda terlebih dahulu.');
        }

        $profesiList = DB::table('profesi')->select('profesi_id', 'nama_profesi')->get();
        $kategoriList = DB::table('kategori_profesi')->select('kategori_id', 'nama_kategori')->get();

        return view('surveialumni.survei', compact('profesiList', 'kategoriList'));
    }

    public function biodataVerifikasi()
    {
        $profesiList = DB::table('profesi')->select('profesi_id', 'nama_profesi')->get();
        $kategoriList = DB::table('kategori_profesi')->select('kategori_id', 'nama_kategori')->get();

        return view('surveialumni.surveibiodata', compact('profesiList', 'kategoriList'));
    }

    public function profesi()
    {
        $profesiList = DB::table('profesi')->select('profesi_id', 'nama_profesi')->get();
        $kategoriList = DB::table('kategori_profesi')->select('kategori_id', 'nama_kategori')->get();

        return view('surveialumni.surveiprofesi', compact('profesiList', 'kategoriList'));
    }
     
    public function store(Request $request)
    {
        // Check if user has been verified through session
        if (!session('verified_alumni')) {
            return redirect()->route('alumni.survey.verification')
                ->with('error', 'Silakan verifikasi identitas Anda terlebih dahulu.');
        }

        // Use verified alumni data from session
        $verifiedAlumni = session('verified_alumni');
        $request->merge([
            'nim' => $verifiedAlumni['nim'],
            'kode_otp_alumni' => $verifiedAlumni['kode_otp_alumni']
        ]);

        $kategoriBelumBekerja = false;
        $profesiBelumBekerja = false;

        // Cek apakah kategori/profesi "Belum Bekerja"
        $kategoriNama = null;
        $profesiNama = null;
        if ($request->kategori_id) {
            $kategoriNama = DB::table('kategori_profesi')->where('kategori_id', $request->kategori_id)->value('nama_kategori');
        }
        if ($request->profesi_id) {
            $profesiNama = DB::table('profesi')->where('profesi_id', $request->profesi_id)->value('nama_profesi');
        }
        if (
            ($kategoriNama && strtolower(trim($kategoriNama)) === 'belum bekerja') &&
            ($profesiNama && strtolower(trim($profesiNama)) === 'belum bekerja')
        ) {
            $kategoriBelumBekerja = true;
            $profesiBelumBekerja = true;
        }

        // Validasi: no_telepon dan email wajib diisi, field lain required hanya jika bukan "Belum Bekerja"
        $rules = [
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
            'kategori_id' => 'required|exists:kategori_profesi,kategori_id',
            'profesi_id' => 'required|exists:profesi,profesi_id',
            'no_telepon' => 'required|string|max:100',
            'email' => 'required|email|max:100',
        ];

        if (!($kategoriBelumBekerja && $profesiBelumBekerja)) {
            // Jika bukan "Belum Bekerja", field lain wajib diisi
            $rules = array_merge($rules, [
                'tanggal_pertama_kerja' => 'required|date',
                'masa_tunggu' => 'required|integer|min:0',
                'tanggal_pertama_kerja_instansi_saat_ini' => 'required|date|after_or_equal:tanggal_pertama_kerja',
                'jenis_instansi' => 'required|string|max:100',
                'nama_instansi' => 'required|string|max:100',
                'skala' => 'required|string|max:100',
                'lokasi_instansi' => 'required|string|max:255',
                'nama_atasan' => 'required|string|max:100',
                'jabatan_atasan' => 'required|string|max:100',
                'no_telepon_atasan' => 'required|string|max:100',
                'email_atasan' => 'required|email|max:100',
                'pendapatan' => 'required|integer|min:0',
                'alamat_kantor' => 'required|string|max:255',
                'kabupaten' => 'required|string|max:255',
            ]);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $sudahIsi = DB::table('survei_alumni')->where('nim', $verifiedAlumni['nim'])->exists();
            if ($sudahIsi) {
                return redirect()->back()->withInput()
                    ->withErrors(['nim' => 'Anda sudah mengisi survei ini sebelumnya.']);
            }

            // Generate kode OTP perusahaan: 2 huruf (dari nama atasan, atau random jika kurang dari 2 huruf) + 2 angka random
            $namaAtasanParts = explode(' ', $request->nama_atasan);
            $inisial = '';
            if (count($namaAtasanParts) > 1) {
                $inisial .= strtoupper(substr($namaAtasanParts[0], 0, 1));
                $inisial .= strtoupper(substr(end($namaAtasanParts), 0, 1));
            } else {
                $nama = strtoupper(preg_replace('/[^A-Z]/i', '', $namaAtasanParts[0] ?? ''));
                if (strlen($nama) >= 2) {
                    $inisial = substr($nama, 0, 2);
                } elseif (strlen($nama) === 1) {
                    $inisial = $nama . chr(rand(65, 90));
                } else {
                    $inisial = chr(rand(65, 90)) . chr(rand(65, 90));
                }
            }
            $randomNumber = str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT);
            $companyOtp = $inisial . $randomNumber;

            $tahunLulus = $request->tahun_lulus ?? DB::table('alumni')
                ->where('nim', $request->nim)
                ->value(DB::raw('YEAR(tanggal_lulus)'));

            $alumniName = DB::table('alumni')->where('nim', $request->nim)->value('nama');

            // Helper: jika belum bekerja, semua field selain no_telepon dan email = null, jika tidak bisa null maka isi '-'
            function fillFieldNullOrDash($val, $type = 'string') {
                if ($type === 'date') {
                    return ($val === null || $val === '' || $val === '-' || $val === '0000-00-00') ? null : $val;
                }
                if ($type === 'int') {
                    return ($val === null || $val === '' || $val === '-') ? 0 : $val;
                }
                return ($val === null || $val === '' || $val === '-') ? '-' : $val;
            }

            $data = [
                'nim' => $verifiedAlumni['nim'],
                'kode_otp_alumni' => $verifiedAlumni['kode_otp_alumni'],
                'tahun_lulus' => $verifiedAlumni['tahun_lulus'],
                'kategori_id' => $request->kategori_id,
                'profesi_id' => $request->profesi_id,
                'no_telepon' => $request->no_telepon,
                'email' => $request->email,
            ];

            if ($kategoriBelumBekerja && $profesiBelumBekerja) {
                // Semua field lain isi dengan null atau '-' agar tidak error (kecuali no_telepon dan email)
                $data = array_merge($data, [
                    'tanggal_pertama_kerja' => null,
                    'masa_tunggu' => 0,
                    'tanggal_pertama_kerja_instansi_saat_ini' => null,
                    'jenis_instansi' => '-',
                    'nama_instansi' => '-',
                    'skala' => '-',
                    'lokasi_instansi' => '-',
                    'nama_atasan' => '-',
                    'jabatan_atasan' => '-',
                    'no_telepon_atasan' => '-',
                    'email_atasan' => '-',
                    'pendapatan' => 0,
                    'alamat_kantor' => '-',
                    'kabupaten' => '-',
                    'kode_otp_perusahaan' => '-',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $data = array_merge($data, [
                    'tanggal_pertama_kerja' => fillFieldNullOrDash($request->tanggal_pertama_kerja, 'date'),
                    'masa_tunggu' => fillFieldNullOrDash($request->masa_tunggu, 'int'),
                    'tanggal_pertama_kerja_instansi_saat_ini' => fillFieldNullOrDash($request->tanggal_pertama_kerja_instansi_saat_ini, 'date'),
                    'jenis_instansi' => fillFieldNullOrDash($request->jenis_instansi),
                    'nama_instansi' => fillFieldNullOrDash($request->nama_instansi),
                    'skala' => fillFieldNullOrDash($request->skala),
                    'lokasi_instansi' => fillFieldNullOrDash($request->lokasi_instansi),
                    'nama_atasan' => fillFieldNullOrDash($request->nama_atasan),
                    'jabatan_atasan' => fillFieldNullOrDash($request->jabatan_atasan),
                    'no_telepon_atasan' => fillFieldNullOrDash($request->no_telepon_atasan),
                    'email_atasan' => fillFieldNullOrDash($request->email_atasan),
                    'pendapatan' => fillFieldNullOrDash($request->pendapatan, 'int'),
                    'alamat_kantor' => fillFieldNullOrDash($request->alamat_kantor),
                    'kabupaten' => fillFieldNullOrDash($request->kabupaten),
                    'kode_otp_perusahaan' => fillFieldNullOrDash($companyOtp),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::table('survei_alumni')->insert($data);

            // Kirim OTP ke email atasan (perusahaan) jika bukan belum bekerja
            if (!$kategoriBelumBekerja && !$profesiBelumBekerja && $request->filled('email_atasan')) {
                try {
                    Mail::to($request->email_atasan)->send(new \App\Mail\CompanyOtpMail($companyOtp, $alumniName));
                } catch (\Exception $e) {
                    // Email gagal dikirim, log jika perlu
                }
            }

            // Clear verification session after successful submission
            session()->forget('verified_alumni');

            return redirect()->route('alumni.survey.verification')->with('success', 'Survei berhasil disimpan' . 
                (($kategoriBelumBekerja && $profesiBelumBekerja) ? '' : ' dan Kode OTP telah dikirim ke email atasan anda.'));
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