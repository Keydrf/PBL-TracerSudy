<?php

namespace App\Http\Controllers;

use App\Models\Profesi;
use App\Models\KategoriProfesi; // Pastikan kategori ada di sini
use Illuminate\Http\Request;


class ProfesiController extends Controller
{
    public function index()
    {
        $profesi = Profesi::with('kategori')->get(); // Mengambil profesi beserta kategori
        return view('profesi.index', compact('profesi'));
    }

    public function create()
    {
        $kategori = KategoriProfesi::all(); // Ambil semua kategori untuk form
        return view('profesi.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_profesi,kategori_id',
            'nama_profesi' => 'required|max:100',
            'deskripsi' => 'required|max:100',
        ]);

        Profesi::create($request->all());
        return redirect()->route('profesi.index');
    }

    public function edit($id)
    {
        $profesi = Profesi::findOrFail($id);
        $kategori = KategoriProfesi::all(); // Ambil semua kategori untuk form edit
        return view('profesi.edit', compact('profesi', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_profesi,kategori_id',
            'nama_profesi' => 'required|max:100',
            'deskripsi' => 'required|max:100',
        ]);

        $profesi = Profesi::findOrFail($id);
        $profesi->update($request->all());
        return redirect()->route('profesi.index');
    }

    public function destroy($id)
    {
        Profesi::destroy($id);
        return redirect()->route('profesi.index');
    }
    public function delete_ajax($id)
    {
        $profesi = Profesi::findOrFail($id);
        $profesi->delete();
    
        return response()->json(['success' => 'Profesi berhasil dihapus']);
    }    
}
