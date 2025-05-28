<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\CompanyOtpMail; // Pastikan Anda memiliki Mailable ini

class AlumniSurveyController extends Controller
{
    /**
     * Menampilkan formulir survei alumni.
     * Mengambil daftar profesi dan kategori profesi dari database untuk mengisi dropdown.
     */
    public function create()
    {
        // Mengambil daftar profesi dari tabel 'profesi'
        $profesiList = DB::table('profesi')->select('profesi_id', 'nama_profesi')->get();
        // Mengambil daftar kategori profesi dari tabel 'kategori_profesi'
        $kategoriList = DB::table('kategori_profesi')->select('kategori_id', 'nama_kategori')->get();

        // Mengirimkan data ke view
        return view('surveialumni.survei', compact('profesiList', 'kategoriList'));
    }

    /**
     * Menyimpan data survei yang dikirimkan oleh alumni.
     * Melakukan validasi data, memeriksa duplikasi, dan menyimpan ke database.
     * Juga menghasilkan dan mengirim OTP ke email atasan.
     */
    public function store(Request $request)
    {
        // Aturan validasi untuk semua bidang yang wajib diisi (non-nullable) di database
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
            // 'program_studi' => 'nullable|string|max:100', // JANGAN validasi/mengirim program_studi
            // 'tahun_lulus' => 'nullable|integer', // JANGAN validasi/mengirim tahun_lulus
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

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan error dan input lama
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Cek apakah alumni sudah mengisi survei sebelumnya untuk mencegah duplikasi
            $sudahIsi = DB::table('survei_alumni')->where('nim', $request->nim)->exists();
            if ($sudahIsi) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['nim' => 'Anda sudah mengisi survei ini sebelumnya. Anda tidak dapat mengisi survei lebih dari satu kali.']);
            }

            // Generate kode OTP untuk email perusahaan: 2 huruf kapital + 2 angka, total 4 digit
            $companyOtp = strtoupper(Str::random(2)) . str_pad(strval(random_int(0, 99)), 2, '0', STR_PAD_LEFT);

            // Ambil tahun_lulus dari request, jika tidak ada ambil dari alumni (YEAR(tanggal_lulus))
            $tahunLulus = $request->tahun_lulus;
            if (!$tahunLulus) {
                $tahunLulus = DB::table('alumni')
                    ->where('nim', $request->nim)
                    ->value(DB::raw('YEAR(tanggal_lulus)'));
            }

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

            // Kirim OTP ke email atasan (perusahaan) jika email tersedia
            if ($request->filled('email_atasan')) {
                Mail::to($request->email_atasan)->send(new CompanyOtpMail($companyOtp));
            }

            return redirect()->back()->with('success', 'Survei berhasil disimpan dan OTP perusahaan telah dikirim.');
        } catch (\Exception $e) {
            // Tangani kesalahan dan kembalikan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Mencari alumni berdasarkan NIM atau nama.
     * Digunakan oleh fitur pencarian di formulir.
     */
    public function search(Request $request)
    {
        $term = $request->input('term');

        // Hanya melakukan pencarian jika term memiliki minimal 3 karakter
        if (strlen($term) < 3) {
            return response()->json([]);
        }

        // Mengambil alumni dari tabel 'alumni' yang cocok dengan term pencarian
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
