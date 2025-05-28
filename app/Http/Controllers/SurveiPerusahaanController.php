<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SurveiPerusahaanController extends Controller
{
    /**
     * Menampilkan formulir survei kepuasan pengguna lulusan.
     */
    public function create()
    {
        // Ambil nama instansi unik yang sudah pernah mengisi survei_perusahaan
        $sudahIsiInstansi = DB::table('survei_perusahaan')
            ->distinct()
            ->pluck('instansi') // Ambil kolom 'instansi' (nama perusahaan penilai)
            ->toArray();

        // Ambil daftar nama instansi unik dari survei_alumni yang belum pernah mengisi survei perusahaan.
        // Ini akan digunakan untuk mengisi dropdown "Perusahaan (Penilai)".
        $alumniList = DB::table('survei_alumni')
            ->select('nama_instansi') // Hanya pilih nama_instansi
            ->whereNotNull('nama_instansi')
            ->whereNotIn('nama_instansi', $sudahIsiInstansi)
            ->distinct() // Pastikan hanya nama instansi yang unik
            ->get();

        return view('surveiperusahaan.survei', compact('alumniList'));
    }

    /**
     * Menyimpan data survei yang dikirimkan.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_instansi_penilai' => 'required|string|max:100',
            'kode_otp_perusahaan' => [
                'required',
                'string',
                'max:4',
                function ($attribute, $value, $fail) use ($request) {
                    $survei = DB::table('survei_alumni')->where('nim', $request->nim)->first();
                    if (!$survei || $survei->kode_otp_perusahaan !== $value) {
                        $fail('OTP perusahaan tidak valid untuk alumni yang dipilih. Silakan masukkan ulang kode OTP yang benar.');
                    }
                },
            ],
            'nama' => 'required|string|max:100',
            'instansi' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'no_telepon' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'nim' => 'required|string|max:10|exists:alumni,nim',
            'kerjasama' => 'required|in:1,2,3,4,5',
            'keahlian' => 'required|in:1,2,3,4,5',
            'kemampuan_basing' => 'required|in:1,2,3,4,5',
            'kemampuan_komunikasi' => 'required|in:1,2,3,4,5',
            'pengembangan_diri' => 'required|in:1,2,3,4,5',
            'kepemimpinan' => 'required|in:1,2,3,4,5',
            'etoskerja' => 'required|in:1,2,3,4,5',
            'kompetensi_yang_belum_dipenuhi' => 'required|string|max:255',
            'saran' => 'required|string|max:255',
        ], [
            'required' => 'Field ini wajib diisi.',
            'email' => 'Format email tidak valid.',
            'in' => 'Pilihan tidak valid.',
            'max' => 'Maksimal :max karakter.',
            'exists' => 'Data tidak ditemukan.',
        ]);

        // Cek apakah perusahaan penilai (dari dropdown 'instansi') sudah pernah mengisi survei
        $sudahIsi = DB::table('survei_perusahaan')
            ->whereRaw('LOWER(TRIM(instansi)) = ?', [strtolower(trim($request->instansi))])
            ->exists();

        if ($sudahIsi) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['instansi' => 'Survei untuk perusahaan ini sudah pernah diisi. Data perusahaan yang sudah pernah diisi tidak akan muncul lagi di daftar pilihan.']);
        }

        // Cek apakah kode OTP perusahaan sudah pernah digunakan untuk survei ini (tidak boleh duplikat)
        $otpUsed = DB::table('survei_perusahaan')
            ->where('kode_otp_perusahaan', $request->kode_otp_perusahaan)
            ->exists();

        if ($otpUsed) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['kode_otp_perusahaan' => 'Kode OTP ini sudah pernah digunakan untuk mengisi survei. Anda tidak dapat mengisi survei lebih dari satu kali dengan kode OTP yang sama.']);
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Mapping angka ke label
        $nilaiMap = [
            '1' => 'Sangat Kurang',
            '2' => 'Kurang',
            '3' => 'Cukup',
            '4' => 'Baik',
            '5' => 'Sangat Baik',
        ];

        try {
            // Simpan data survei perusahaan
            DB::insert('INSERT INTO survei_perusahaan (
                kode_otp_perusahaan, nama, instansi, jabatan, no_telepon, email, nim,
                kerjasama, keahlian, kemampuan_basing, kemampuan_komunikasi,
                pengembangan_diri, kepemimpinan, etoskerja, kompetensi_yang_belum_dipenuhi, saran,
                created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->kode_otp_perusahaan,
                $request->nama,
                $request->instansi,
                $request->jabatan,
                $request->no_telepon,
                $request->email,
                $request->nim,
                $nilaiMap[$request->kerjasama],
                $nilaiMap[$request->keahlian],
                $nilaiMap[$request->kemampuan_basing],
                $nilaiMap[$request->kemampuan_komunikasi],
                $nilaiMap[$request->pengembangan_diri],
                $nilaiMap[$request->kepemimpinan],
                $nilaiMap[$request->etoskerja],
                $request->kompetensi_yang_belum_dipenuhi,
                $request->saran,
                now(),
                now()
            ]);

            return redirect()->back()->with('success', 'Data survei berhasil disimpan! Terima kasih.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Mencari alumni berdasarkan NIM atau nama untuk survei.
     */
    public function searchAlumni(Request $request)
    {
        $term = $request->input('term');

        if (strlen($term) < 3) {
            return response()->json([]);
        }

        // Ambil alumni yang sudah mengisi survei_alumni (join by nim)
        $results = DB::select("
            SELECT a.nim, a.nama, a.program_studi, YEAR(a.tanggal_lulus) as tahun_lulus
            FROM alumni a
            INNER JOIN survei_alumni sa ON sa.nim = a.nim
            WHERE a.nim LIKE ? OR a.nama LIKE ?
            ORDER BY a.nama ASC
            LIMIT 10
        ", ["%{$term}%", "%{$term}%"]);

        return response()->json($results);
    }

    /**
     * Mendapatkan data perusahaan untuk autofill.
     */
    public function getPerusahaanData($nim)
    {
        // Ambil data perusahaan berdasarkan nim alumni dari survei_alumni
        $survei = DB::table('survei_alumni')
            ->where('nim', $nim)
            ->first();

        if ($survei) {
            // Atau langsung kembalikan data survei_alumni (termasuk nama_instansi, dsb)
            return response()->json([
                'success' => true,
                'data' => $survei
            ]);
        }

        return response()->json(['success' => false]);
    }
}

