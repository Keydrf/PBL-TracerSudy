<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function index()
    {
        $kategori = LevelModel::all();

        return view('level.index');
    }

    public function list(Request $request)
    {
        $level = LevelModel::select('level_id','level_kode', 'level_nama');



        return DataTables::of($level)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) { // menambahkan kolom aksi
                /*$btn = '<a href="'.url('/alu,ni/' . $level->barang_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/alu,ni/' . $level->barang_id . '/edit').'"class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.
                    url('/alu,ni/'.$level->barang_id).'">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Kita yakit menghapus data ini?\');">Hapus</button></form>';*/
                
                $btn = '<a href="' . url('/level/' . $level->level_id . '/edit') . '" class="btn btn-warning btn-sm"><i class="mdi mdi-pencil"></i></a>';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm"><i class="mdi mdi-delete"></i></button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // ada teks html
            ->make(true);
    }

    public function create()
    {

        $level = LevelModel::all();

        return view('level.create', ['level' => $level]);
    }

    public function store(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'level_kode' => 'required|string|min:3|unique:level,level_kode',
            'level_nama' => 'required|string|max:100',
        ]);

        // Buat level baru menggunakan Eloquent Mass Assignment
        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        // Redirect dengan pesan sukses
        return redirect('/level')->with('success', 'Data level berhasil disimpan.');
    }

    public function edit(string $id)
    {
        $level = LevelModel::findOrFail($id);
        return view('level.edit', ['level'=> $level]);
    }



    // Menyimpan perubahan data level
    public function update(Request $request, string $id)
    {
        $request->validate([
            'level_kode' => 'required|string|min:3|unique:level,level_kode,' . $id . ',level_id',
            'level_nama' => 'required|string|max:100',
        ]);

        // Ambil data level dari database
        $level = LevelModel::find($id);

        // Cek apakah level ditemukan
        if (!$level) {
            return redirect('/level')->with('error', 'level tidak ditemukan');
        }

        // Update data level
        $level->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        return redirect('/level')->with('success', 'Data level berhasil diubah');
    }

    public function confirm_ajax(string $id)
    {
        $level = LevelModel::find($id);
        return view('level.confirm_ajax', ['level' => $level]);
    }

    // hapus ajax
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $level = LevelModel::find($id);

            if ($level) {
                $level->delete();
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
