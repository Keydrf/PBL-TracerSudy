<?php

namespace App\Http\Controllers;

use App\Models\ProfesiModel;
use App\Models\KategoriProfesiModel; // Pastikan kategori ada di sini
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


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
                $btn = '<a href="' . url('/profesi/' . $profesi->profesi_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a>';
                $btn .= '<button onclick="modalAction(\'' . url('/profesi/' . $profesi->profesi_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
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
                $profesi->delete();
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
        return redirect('/profesi');
    }
}
