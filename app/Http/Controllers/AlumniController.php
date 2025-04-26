<?php

namespace App\Http\Controllers;

use App\Models\AlumniModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class AlumniController extends Controller
{
    public function index()
    {
        return view('adminalumni.index');
    }

    public function list(Request $request)
    {
        $alumni = AlumniModel::select('alumni_id', 'program_studi', 'nim', 'nama', 'tanggal_lulus');

        return DataTables::of($alumni)
            ->addIndexColumn()
            ->addColumn('aksi', function ($alumni) {
                $btn = '<a href="' . url('/alumni/' . $alumni->alumni_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a>';
                $btn .= '<button onclick="modalAction(\'' . url('/alumni/' . $alumni->alumni_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
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
        ]);

        AlumniModel::create($request->all());

        return redirect('/alumni')->with('success', 'Data alumni berhasil disimpan.');
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
            'tanggal_lulus' => 'required|date_format:Y-m-d\TH:i',
        ]);

        $alumni = AlumniModel::findOrFail($id);
        $alumni->update($request->all());

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
                $alumni->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
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
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            if (!$request->hasFile('file_alumni')) {
                return response()->json([
                    'status' => false,
                    'message' => 'File tidak ditemukan.'
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
                $errors = []; // Untuk menyimpan error per baris (opsional)

                foreach ($data as $key => $row) {
                    if ($key === 1) continue; // Skip header

                    $programStudi = $row['A'] ?? null;
                    $nim = $row['B'] ?? null;
                    $nama = $row['C'] ?? null;
                    $tanggalLulusExcel = $row['D'] ?? null; // Ambil nilai tanggal dari Excel

                    if ($programStudi && $nim && $nama && $tanggalLulusExcel) {
                        $existing = AlumniModel::where('nim', $nim)->first();
                        if (!$existing) {
                            try {
                                // Coba konversi jika berupa angka serial Excel
                                if (is_numeric($tanggalLulusExcel)) {
                                    $timestamp = ExcelDate::excelToTimestamp($tanggalLulusExcel);
                                    $tanggalLulusFormatted = Carbon::createFromTimestamp($timestamp)->format('Y-m-d H:i:s');
                                } else {
                                    // Jika bukan angka, coba parse sebagai string dengan format d/m/Y
                                    // Anda bisa menambahkan format lain jika diperlukan
                                    try {
                                        $tanggalLulusFormatted = Carbon::createFromFormat('d/m/Y', $tanggalLulusExcel)->format('Y-m-d H:i:s');
                                    } catch (\Exception $e) {
                                        // Jika format d/m/Y gagal, coba format Y-m-d (format default Carbon)
                                        try {
                                            $tanggalLulusFormatted = Carbon::parse($tanggalLulusExcel)->format('Y-m-d H:i:s');
                                        } catch (\Exception $e2) {
                                            $errors[] = "Gagal memproses tanggal lulus pada baris ke-$key: Tidak dapat mengenali format tanggal (Nilai: " . $tanggalLulusExcel . ")";
                                            $tanggalLulusFormatted = null; // Set null agar tidak terjadi error saat create
                                        }
                                    }
                                }

                                if ($tanggalLulusFormatted) {
                                    AlumniModel::create([
                                        'program_studi' => $programStudi,
                                        'nim' => $nim,
                                        'nama' => $nama,
                                        'tanggal_lulus' => $tanggalLulusFormatted,
                                    ]);
                                    $inserted++;
                                }
                            } catch (\Exception $dateException) {
                                $errors[] = "Gagal memproses data pada baris ke-$key: " . $dateException->getMessage() . " (Nilai Tanggal: " . $tanggalLulusExcel . ")";
                            }
                        }
                    } else if ($programStudi || $nim || $nama || $tanggalLulusExcel) {
                        $errors[] = "Data tidak lengkap pada baris ke-$key.";
                    }
                }

                $message = "Import berhasil. $inserted data alumni ditambahkan.";
                if (!empty($errors)) {
                    $message .= "\nBeberapa baris gagal diproses karena masalah berikut:\n" . implode("\n", $errors);
                }

                return response()->json([
                    'status' => true,
                    'message' => $message
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat memproses file: ' . $e->getMessage()
                ]);
            }
        }

        return redirect('/alumni');
    }

}
