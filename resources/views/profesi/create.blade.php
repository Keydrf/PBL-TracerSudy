@extends('layouts.app')

@section('content')
<h2>Tambah Profesi</h2>
<form method="POST" action="{{ route('profesi.store') }}">
    @csrf
    <label>Kategori:</label>
    <select name="kategori_id" required>
        <option value="">--Pilih Kategori--</option>
        @foreach($kategori as $kat)
            <option value="{{ $kat->kategori_id }}">{{ $kat->nama_kategori }}</option>
        @endforeach
    </select><br>

    <label>Nama Profesi:</label>
    <input type="text" name="nama_profesi" required><br>

    <label>Deskripsi:</label>
    <input type="text" name="deskripsi" required><br>

    <button type="submit">Simpan</button>
</form>
@endsection
