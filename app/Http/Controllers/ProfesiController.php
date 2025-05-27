<?php

namespace App\Http\Controllers;

use App\Models\ProfesiModel;
use App\Models\KategoriProfesiModel; // Pastikan kategori ada di sini
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Database\QueryException;


class ProfesiController extends Controller
{
    public function index()
    {
        $profesi = KategoriProfesiModel::all(); // Mengambil profesi beserta kategori
        return view('profesi.index');
    }

    public function list(Request $request)
    {
        $profesi = ProfesiModel::select('profesi_id', 'nama_profesi', 'deskripsi', 'kategori_id')
            ->with('kategori_profesi'); // Pastikan relasi 'kategoriProfesi' sudah benar

        return DataTables::of($profesi)
            ->addIndexColumn()
            ->addColumn('aksi', function ($profesi) {
                $btn = '<a href="' . url('/profesi/' . $profesi->profesi_id . '/edit') . '" class="btn btn-warning btn-sm"><i class="mdi mdi-pencil"></i></a>';
                $btn .= '<button onclick="modalAction(\'' . url('/profesi/' . $profesi->profesi_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm"><i class="mdi mdi-delete"></i></button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // ada teks html
            ->make(true);
    }

    public function create()
    {
        $kategori = KategoriProfesiModel::all();

        return view('profesi.create', ['kategori' => $kategori]);
    }

    public function store(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'nama_profesi' => 'required|string|max:100|unique:profesi,nama_profesi', // Tambahkan rule unique
            'deskripsi' => 'required|string|max:100',
            'kategori_id' => 'required|integer',
        ]);

        // Buat profesi baru menggunakan Eloquent Mass Assignment
        ProfesiModel::create([
            'nama_profesi' => $request->nama_profesi,
            'deskripsi' => $request->deskripsi,
            'kategori_id' => $request->kategori_id,
        ]);

        // Redirect dengan pesan sukses
        return redirect('/profesi')->with('success', 'Data profesi berhasil disimpan.');
    }

    public function edit(string $id)
    {
        $profesi = ProfesiModel::find($id);
        $kategori_profesi = KategoriProfesiModel::all();



        $page = (object) [
            'title' => 'Edit profesi'
        ];


        return view('profesi.edit', [
            'page' => $page,
            'profesi' => $profesi,
            'kategori_profesi' => $kategori_profesi
        ]);
    }

    // Menyimpan perubahan data profesi
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_profesi' => 'required|string|max:100|unique:profesi,nama_profesi,' . $id . ',profesi_id',
            'deskripsi' => 'required|string|max:100',
            'kategori_id' => 'required|integer'
        ]);

        // Ambil data profesi dari database
        $profesi = ProfesiModel::find($id);

        // Cek apakah profesi ditemukan
        if (!$profesi) {
            return redirect('/profesi')->with('error', 'Profesi tidak ditemukan');
        }

        // Update data profesi
        $profesi->update([
            'nama_profesi' => $request->nama_profesi,
            'deskripsi' => $request->deskripsi,
            'kategori_id' => $request->kategori_id
        ]);

        return redirect('/profesi')->with('success', 'Data profesi berhasil diubah');
    }

    public function confirm_ajax(string $id)
    {
        $profesi = ProfesiModel::find($id);
        return view('profesi.confirm', ['profesi' => $profesi]);
    }

    // hapus ajax
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $profesi = ProfesiModel::find($id);

            if ($profesi) {
                try {
                    $profesi->delete();
                    return response()->json([
                        'status' => true,
                        'message' => 'Data profesi berhasil dihapus.'
                    ]);
                } catch (QueryException $e) {
                    // Periksa apakah exception disebabkan oleh foreign key constraint
                    // Kode error SQL '23000' umumnya menunjukkan integrity constraint violation
                    if ($e->getCode() === '23000') {
                        return response()->json([
                            'status' => false,
                            'message' => 'Data tidak dapat dihapus karena masih digunakan di tabel lain.'
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
                    'message' => 'Data profesi tidak ditemukan.'
                ]);
            }
        }
        return redirect('/profesi');
    }

    public function sebaranProfesiView(): View
    {
        // Data untuk grafik sebaran berdasarkan kategori
        $dataKategori = DB::table('survei_alumni')
            ->join('profesi', 'survei_alumni.profesi_id', '=', 'profesi.profesi_id')
            ->join('kategori_profesi', 'profesi.kategori_id', '=', 'kategori_profesi.kategori_id')
            ->select('kategori_profesi.nama_kategori', DB::raw('count(*) as jumlah_alumni'))
            ->whereIn('kategori_profesi.kode_kategori', ['K001', 'K002'])
            ->groupBy('kategori_profesi.nama_kategori')
            ->get()
            ->toArray();

        $labelsKategori = array_column($dataKategori, 'nama_kategori');
        $jumlahAlumniKategori = array_map('round', array_column($dataKategori, 'jumlah_alumni'));

        // Data untuk grafik sebaran profesi di dalam kategori Infokom
        $dataProfesiInfokom = DB::table('survei_alumni')
            ->join('profesi', 'survei_alumni.profesi_id', '=', 'profesi.profesi_id')
            ->join('kategori_profesi', 'profesi.kategori_id', '=', 'kategori_profesi.kategori_id')
            ->select('profesi.nama_profesi', DB::raw('count(*) as jumlah_alumni'))
            ->where('kategori_profesi.kode_kategori', 'K001')
            ->groupBy('profesi.nama_profesi')
            ->orderBy('jumlah_alumni', 'desc')
            ->limit(10)
            ->get()
            ->toArray();

        $labelsProfesiInfokom = array_column($dataProfesiInfokom, 'nama_profesi');
        $jumlahAlumniProfesiInfokom = array_map('round', array_column($dataProfesiInfokom, 'jumlah_alumni'));

        // Data untuk grafik sebaran profesi di dalam kategori Non-Infokom
        $dataProfesiNonInfokom = DB::table('survei_alumni')
            ->join('profesi', 'survei_alumni.profesi_id', '=', 'profesi.profesi_id')
            ->join('kategori_profesi', 'profesi.kategori_id', '=', 'kategori_profesi.kategori_id')
            ->select('profesi.nama_profesi', DB::raw('count(*) as jumlah_alumni'))
            ->where('kategori_profesi.kode_kategori', 'K002')
            ->groupBy('profesi.nama_profesi')
            ->orderBy('jumlah_alumni', 'desc')
            ->limit(10)
            ->get()
            ->toArray();

        $labelsProfesiNonInfokom = array_column($dataProfesiNonInfokom, 'nama_profesi');
        $jumlahAlumniProfesiNonInfokom = array_map('round', array_column($dataProfesiNonInfokom, 'jumlah_alumni'));

        return view('sebaranprofesi.index', [
            'labelsKategori' => $labelsKategori,
            'dataKategori' => $jumlahAlumniKategori,
            'labelsProfesiInfokom' => $labelsProfesiInfokom,
            'dataProfesiInfokom' => $jumlahAlumniProfesiInfokom,
            'labelsProfesiNonInfokom' => $labelsProfesiNonInfokom,
            'dataProfesiNonInfokom' => $jumlahAlumniProfesiNonInfokom,
        ]);
    }
}
