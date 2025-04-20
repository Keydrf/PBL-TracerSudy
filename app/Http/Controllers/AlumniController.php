<?php

namespace App\Http\Controllers;

use App\Models\AlumniModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
}