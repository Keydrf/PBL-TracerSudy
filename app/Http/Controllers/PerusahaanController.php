<?php

namespace App\Http\Controllers;

use App\Models\PerusahaanModel;
use App\Models\SurveiAlumniModel;
use App\Models\AlumniModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class PerusahaanController extends Controller
{
    // Tampilkan semua data perusahaan beserta data survei_alumni-nya
    public function populate()
    {
        // Fungsi helper untuk generate kode 4 digit unik
        function generateUniqueCode()
        {
            do {
                $code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
                $exists = PerusahaanModel::where('kode_perusahaan', $code)->exists();
            } while ($exists);
            return $code;
        }

        // Ambil ID survei_alumni yang sudah ada di tabel perusahaan
        $existingSurveiIds = PerusahaanModel::pluck('survei_alumni_id')->toArray();

        // Ambil data survei_alumni yang belum ada di tabel perusahaan
        $surveiAlumnis = SurveiAlumniModel::whereNotIn('survei_alumni_id', $existingSurveiIds)->latest()->get();

        if ($surveiAlumnis->isEmpty()) {
            return redirect()->route('perusahaan.index')
                ->with('success', 'Tidak ada data survei alumni baru untuk ditambahkan ke tabel perusahaan.');
        }

        // Transaksi DB untuk integritas data
        DB::transaction(function () use ($surveiAlumnis) {
            foreach ($surveiAlumnis as $survei) {
                // Cari data alumni berdasarkan NIM
                $alumni = AlumniModel::where('nim', $survei->nim)->first();

                // Jika tidak ditemukan, lanjutkan ke survei berikutnya
                if (!$alumni) {
                    continue;
                }

                // Siapkan data untuk insert
                $perusahaanData = [
                    'survei_alumni_id' => $survei->survei_alumni_id,
                    'nama_atasan' => $survei->nama_atasan ?? 'Atasan Tidak Diketahui',
                    'instansi' => $survei->jenis_instansi ?? 'Instansi Tidak Diketahui',
                    'nama_instansi' => $survei->nama_instansi ?? 'Nama Instansi Tidak Diketahui',
                    'no_telepon' => $survei->no_telepon ?? '0000000000',
                    'email' => $survei->email ?? 'default@email.com',
                    'nama_alumni' => $alumni->nama,
                    'program_studi' => $alumni->program_studi,
                    'tanggal_lulus' => $alumni->tanggal_lulus, // Pastikan ini disimpan dalam format tanggal jika perlu
                    'kode_perusahaan' => generateUniqueCode(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                PerusahaanModel::insert($perusahaanData);
            }
        });

        return redirect()->route('perusahaan.index')
            ->with('success', 'Tabel perusahaan berhasil diisi dengan data survei alumni terbaru.');
    }



    public function index()
    {
        $perusahaans = PerusahaanModel::with('surveiAlumni')->get();
        return view('perusahaan.index', compact('perusahaans'));
    }
    public function list(Request $request)
    {
        $perusahaan = PerusahaanModel::select(
            'nama_atasan',
            'instansi',
            'nama_instansi',
            'no_telepon',
            'email',
            'nama_alumni',
            'program_studi',
            'tanggal_lulus'
        );

        return DataTables::of($perusahaan)
            ->addIndexColumn()
            ->editColumn('tanggal_lulus', function ($row) {
                return \Carbon\Carbon::parse($row->tanggal_lulus)->format('Y');
            })
            ->make(true);
    }



    // Form tambah data perusahaan
    public function create()
    {
        // Kirim data survei_alumni untuk pilihan relasi
        $surveiAlumnis = SurveiAlumniModel::all();
        return view('perusahaan.index', compact('surveiAlumnis'));
    }

    // Simpan data perusahaan
    public function store(Request $request)
    {
        $request->validate([
            'survei_alumni_id' => 'required|exists:survei_alumni,survei_alumni_id',
            'nama_atasan' => 'required|string|max:100',
            'instansi' => 'required|string|max:100',
            'nama_instansi' => 'required|string|max:100',
            'no_telepon' => 'required|string|max:30',
            'email' => 'required|email|max:100',
            'nama_alumni' => 'required|string|max:100',
            'program_studi' => 'required|string|max:100',
            'tanggal_lulus' => 'required|date',
        ]);

        PerusahaanModel::create($request->all());

        return redirect()->route('landingpage')->with('success', 'Data perusahaan berhasil ditambahkan.');
    }

    // Tampilkan detail perusahaan
    public function show($id)
    {
        $perusahaan = PerusahaanModel::with('surveiAlumni')->findOrFail($id);
        return view('perusahaan.show', compact('perusahaan'));
    }

    // Form edit
    public function edit($id)
    {
        $perusahaan = PerusahaanModel::findOrFail($id);
        $surveiAlumnis = SurveiAlumniModel::all();
        return view('perusahaan.edit', compact('perusahaan', 'surveiAlumnis'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'survei_alumni_id' => 'required|exists:survei_alumni,survei_alumni_id',
            'nama_atasan' => 'required|string|max:100',
            'instansi' => 'required|string|max:100',
            'nama_instansi' => 'required|string|max:100',
            'no_telepon' => 'required|string|max:30',
            'email' => 'required|email|max:100',
            'nama_alumni' => 'required|string|max:100',
            'program_studi' => 'required|string|max:100',
            'tanggal_lulus' => 'required|date',
        ]);

        $perusahaan = PerusahaanModel::findOrFail($id);
        $perusahaan->update($request->all());

        return redirect()->route('landingpage')->with('success', 'Data perusahaan berhasil diperbarui.');
    }

    // Hapus data
    public function destroy($id)
    {
        $perusahaan = PerusahaanModel::findOrFail($id);
        $perusahaan->delete();

        return redirect()->route('landingpage')->with('success', 'Data perusahaan berhasil dihapus.');
    }
}
