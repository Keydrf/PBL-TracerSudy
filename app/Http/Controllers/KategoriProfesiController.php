<?php

namespace App\Http\Controllers;

use App\Models\KategoriProfesiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriProfesiController extends Controller
{
    public function index()
    {
        return view('kategoriprofesi.index');
    }

    public function list(Request $request)
    {
        $kategoriProfesi = KategoriProfesiModel::select('kategori_id', 'kode_kategori', 'nama_kategori');

        return DataTables::of($kategoriProfesi)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategoriProfesi) {
                $btn = '<a href="' . url('/kategori/' . $kategoriProfesi->kategori_id . '/edit') . '" class="btn btn-warning btn-sm"><i class="mdi mdi-pencil"></i></a>';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategoriProfesi->kategori_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm"><i class="mdi mdi-delete"></i></button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('kategoriprofesi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori' => 'required|string|max:100|unique:kategori_profesi,kode_kategori',
            'nama_kategori' => 'required|string|max:100|unique:kategori_profesi,nama_kategori',
        ]);

        KategoriProfesiModel::create($request->all());

        return redirect('/kategori')->with('success', 'Data kategori profesi berhasil disimpan.');
    }

    public function edit(string $id)
    {
        $kategoriProfesi = KategoriProfesiModel::findOrFail($id);
        return view('kategoriprofesi.edit', ['kategori_profesi' => $kategoriProfesi]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_kategori' => 'required|string|max:100|unique:kategori_profesi,kode_kategori,' . $id . ',kategori_id',
            'nama_kategori' => 'required|string|max:100|unique:kategori_profesi,nama_kategori,' . $id . ',kategori_id',
        ]);

        $kategoriProfesi = KategoriProfesiModel::findOrFail($id);
        $kategoriProfesi->update($request->all());

        return redirect('/kategori')->with('success', 'Data kategori profesi berhasil diubah');
    }

    public function confirm_ajax(string $id)
    {
        $kategoriProfesi = KategoriProfesiModel::findOrFail($id);
        return view('kategoriprofesi.confirm_ajax', ['kategori_profesi' => $kategoriProfesi]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $kategoriProfesi = KategoriProfesiModel::find($id);

            if ($kategoriProfesi) {
                $kategoriProfesi->delete();
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
}