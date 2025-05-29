<?php

namespace App\Http\Controllers;

use App\Models\AlumniModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

class AlumniController extends Controller
{
    public function index()
    {
        return view('adminalumni.index');
    }

    public function list(Request $request)
    {
        $alumni = AlumniModel::select('alumni_id', 'program_studi', 'nim', 'nama', 'kode_otp_alumni', 'tanggal_lulus', 'email');

        return DataTables::of($alumni)
            ->addIndexColumn()
            ->editColumn('tanggal_lulus', function ($alumni) {
                return Carbon::parse($alumni->tanggal_lulus)->format('d/m/Y');
            })
            ->addColumn('aksi', function ($alumni) {
                $btn = '<a href="' . url('/alumni/' . $alumni->alumni_id . '/edit') . '" class="btn btn-warning btn-sm"><i class="mdi mdi-pencil"></i></a>';
                $btn .= '<button onclick="modalAction(\'' . url('/alumni/' . $alumni->alumni_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm"><i class="mdi mdi-delete"></i></button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('adminalumni.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_studi' => 'required|string|max:100',
            'nim' => 'required|string|max:10|unique:alumni,nim',
            'nama' => 'required|string|unique:alumni,nama',
            'tanggal_lulus' => 'required|date_format:Y-m-d\TH:i',
            'email' => 'required|email|unique:alumni,email',
        ]);

        // Generate kode OTP
        $nama_parts = explode(' ', $request->nama);
        if (count($nama_parts) > 1) {
            $inisial = strtoupper(substr($nama_parts[0], 0, 1) . substr(end($nama_parts), 0, 1));
        } else {
            $inisial = strtoupper(substr($nama_parts[0], 0, 1) . 'X');
        }
        $nim_suffix = substr($request->nim, -2);
        $kode_otp = $inisial . $nim_suffix;

        // Simpan data ke database
        AlumniModel::create([
            'program_studi' => $request->program_studi,
            'nim' => $request->nim,
            'nama' => $request->nama,
            'tanggal_lulus' => $request->tanggal_lulus,
            'email' => $request->email,
            'kode_otp_alumni' => $kode_otp,
        ]);

        // Kirim email OTP
        Mail::to($request->email)->send(new OtpMail($kode_otp));

        return redirect('/alumni')->with('success', 'Data alumni berhasil disimpan dan OTP telah dikirim ke email.');
    }


    public function edit(string $id)
    {
        $alumni = AlumniModel::findOrFail($id);
        return view('adminalumni.edit', ['alumni' => $alumni]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'program_studi' => 'required|string|max:100',
            'nim' => 'required|string|max:10|unique:alumni,nim,' . $id . ',alumni_id',
            'nama' => 'required|string|unique:alumni,nama,' . $id . ',alumni_id',
            'email' => 'required|email|unique:alumni,email,' . $id . ',alumni_id',
            'tanggal_lulus' => 'required|date_format:Y-m-d\TH:i',
        ]);

        $alumni = AlumniModel::findOrFail($id);

        // Generate kode_otp_alumni berdasarkan nama dan nim (logika seperti di store/seeder)
        $nama_parts = explode(' ', $request->nama);
        if (count($nama_parts) > 1) {
            $inisial = strtoupper(substr($nama_parts[0], 0, 1) . substr(end($nama_parts), 0, 1));
        } else {
            $inisial = strtoupper(substr($nama_parts[0], 0, 1) . 'X');
        }
        $nim_suffix = substr($request->nim, -2);
        $kodeOtp = $inisial . $nim_suffix;

        // Update data termasuk kode_otp_alumni dan email
        $alumni->program_studi = $request->program_studi;
        $alumni->nim = $request->nim;
        $alumni->nama = $request->nama;
        $alumni->email = $request->email;
        $alumni->tanggal_lulus = $request->tanggal_lulus;
        $alumni->kode_otp_alumni = $kodeOtp;

        $alumni->save();

        return redirect('/alumni')->with('success', 'Data alumni berhasil diubah');
    }


    public function confirm_ajax(string $id)
    {
        $alumni = AlumniModel::findOrFail($id);
        return view('adminalumni.confirm_ajax', ['alumni' => $alumni]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $alumni = AlumniModel::find($id);

            if ($alumni) {
                try {
                    $alumni->delete();
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } catch (QueryException $e) {
                    // Periksa apakah exception disebabkan oleh foreign key constraint
                    if ($e->getCode() === '23000') { // Kode error SQL untuk constraint violation
                        return response()->json([
                            'status' => false,
                            'message' => 'Data tidak dapat dihapus karena sedang digunakan di table lain.'
                        ]);
                    } else {
                        // Jika error lain, kembalikan pesan error umum
                        return response()->json([
                            'status' => false,
                            'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/alumni');
    }



    public function import()
    {
        return view('adminalumni.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_alumni' => ['required', 'file', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal: File yang diunggah tidak sesuai.',
                    'msgField' => $validator->errors()
                ]);
            }

            if (!$request->hasFile('file_alumni')) {
                return response()->json([
                    'status' => false,
                    'message' => 'File tidak ditemukan. Mohon pilih file Excel untuk diunggah.'
                ]);
            }

            $file = $request->file('file_alumni');

            try {
                $reader = IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray(null, false, true, true); // Kolom A, B, C, D, E

                $inserted = 0;
                $errors = []; // Untuk menyimpan error per baris

                // Periksa apakah file kosong atau hanya berisi header
                if (count($data) <= 1) {
                    return response()->json([
                        'status' => false,
                        'message' => 'File Excel kosong atau hanya berisi header. Tidak ada data untuk diimpor.'
                    ]);
                }

                foreach ($data as $key => $row) {
                    if ($key === 1) continue; // Skip header (baris pertama)

                    // Pastikan baris tidak sepenuhnya kosong
                    $isEmptyRow = true;
                    foreach ($row as $cellValue) {
                        if (!empty($cellValue)) {
                            $isEmptyRow = false;
                            break;
                        }
                    }
                    if ($isEmptyRow) {
                        continue; // Lewati baris yang kosong
                    }

                    $programStudi = $row['A'] ?? null;
                    $nim = $row['B'] ?? null;
                    $nama = $row['C'] ?? null;
                    $email = $row['D'] ?? null; // Email di kolom D
                    $tanggalLulusExcel = $row['E'] ?? null; // Tanggal lulus di kolom E

                    // Validasi dasar untuk memastikan data penting tidak kosong
                    if (!$programStudi || !$nim || !$nama || !$email || !$tanggalLulusExcel) {
                        $errors[] = "Data tidak lengkap pada baris ke-$key. Pastikan semua kolom (Program Studi, NIM, Nama, Email, Tanggal Lulus) terisi.";
                        continue;
                    }

                    // Validasi data per baris secara lebih detail
                    $rowValidator = Validator::make([
                        'program_studi' => $programStudi,
                        'nim' => $nim,
                        'nama' => $nama,
                        'email' => $email,
                        'tanggal_lulus' => $tanggalLulusExcel, // Akan dikonversi nanti
                    ], [
                        'program_studi' => 'required|string|max:100',
                        'nim' => 'required|string|max:10|unique:alumni,nim',
                        'nama' => 'required|string|unique:alumni,nama',
                        'email' => 'required|email|unique:alumni,email',
                        // tanggal_lulus tidak divalidasi format di sini karena akan dikonversi
                    ]);

                    if ($rowValidator->fails()) {
                        $errors[] = "Validasi gagal pada baris ke-$key: " . implode(', ', $rowValidator->errors()->all());
                        continue;
                    }

                    // Cek duplikasi NIM atau Email sebelum mencoba membuat
                    $existing = AlumniModel::where('nim', $nim)->orWhere('email', $email)->first();
                    if ($existing) {
                        $errors[] = "Data duplikat ditemukan (NIM: $nim atau Email: $email) pada baris ke-$key. Data ini akan dilewati.";
                        continue; // Lewati baris duplikat
                    }

                    try {
                        // Konversi tanggal lulus
                        $tanggalLulusFormatted = null;
                        if (is_numeric($tanggalLulusExcel)) {
                            $timestamp = ExcelDate::excelToTimestamp($tanggalLulusExcel);
                            $tanggalLulusFormatted = Carbon::createFromTimestamp($timestamp)->format('Y-m-d H:i:s');
                        } else {
                            try {
                                $tanggalLulusFormatted = Carbon::createFromFormat('d/m/Y', $tanggalLulusExcel)->format('Y-m-d H:i:s');
                            } catch (\Exception $e) {
                                try {
                                    $tanggalLulusFormatted = Carbon::parse($tanggalLulusExcel)->format('Y-m-d H:i:s');
                                } catch (\Exception $e2) {
                                    $errors[] = "Gagal memproses tanggal lulus pada baris ke-$key: Format tanggal tidak dikenali (Nilai: " . $tanggalLulusExcel . ").";
                                    continue; // Lewati baris jika tanggal tidak valid
                                }
                            }
                        }

                        if ($tanggalLulusFormatted) {
                            // Generate kode OTP alumni
                            $nama_parts = explode(' ', $nama);
                            if (count($nama_parts) > 1) {
                                $inisial = strtoupper(substr($nama_parts[0], 0, 1) . substr(end($nama_parts), 0, 1));
                            } else {
                                $inisial = strtoupper(substr($nama_parts[0], 0, 1) . 'X');
                            }
                            $nim_suffix = substr($nim, -2);
                            $kode_otp_alumni = $inisial . $nim_suffix;

                            $alumni = AlumniModel::create([
                                'program_studi' => $programStudi,
                                'nim' => $nim,
                                'nama' => $nama,
                                'email' => $email,
                                'tanggal_lulus' => $tanggalLulusFormatted,
                                'kode_otp_alumni' => $kode_otp_alumni,
                            ]);

                            // Kirim email OTP alumni
                            try {
                                Mail::to($email)->send(new OtpMail($kode_otp_alumni));
                            } catch (\Exception $mailException) {
                                $errors[] = "Gagal mengirim OTP ke email alumni ($email) pada baris ke-$key: " . $mailException->getMessage();
                                // Data alumni tetap disimpan meskipun gagal kirim email
                            }

                            $inserted++;
                        }
                    } catch (\Exception $e) {
                        $errors[] = "Terjadi kesalahan saat memproses data pada baris ke-$key: " . $e->getMessage() . " (Nilai Tanggal: " . $tanggalLulusExcel . ").";
                    }
                }

                // Logika respons akhir berdasarkan hasil import
                $status = true;
                $message = '';

                if ($inserted > 0 && empty($errors)) {
                    $message = "Import berhasil. Sebanyak $inserted data alumni baru telah ditambahkan.";
                } elseif ($inserted > 0 && !empty($errors)) {
                    $message = "Import selesai dengan beberapa kesalahan. Sebanyak $inserted data alumni baru telah ditambahkan.\n\nDetail Kesalahan:\n" . implode("\n", $errors);
                } elseif ($inserted === 0 && !empty($errors)) {
                    $status = false; // Keseluruhan import dianggap gagal
                    $message = "Import gagal. Tidak ada data alumni baru yang ditambahkan.\n\nDetail Kesalahan:\n" . implode("\n", $errors);
                } else { // $inserted === 0 && empty($errors) - ini seharusnya sudah ditangani oleh pengecekan file kosong di awal
                    $message = "Import selesai. Tidak ada data alumni baru yang ditambahkan (mungkin semua data sudah ada atau file kosong).";
                }

                return response()->json([
                    'status' => $status,
                    'message' => $message
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat memproses file Excel: ' . $e->getMessage()
                ]);
            }
        }

        return redirect('/alumni');
    }
}
