@extends('layouts_dashboard.template')

@section('content')

    <div class="card card-outline card-primary">

        <div class="card-body">
            <div class="card-header">
                <h3 class="card-title">Edit Data Profesi</h3>
                <div class="card-tools"></div>
            </div>
            @empty($profesi)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>

                <a href="{{ url('profesi') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/profesi/' . $profesi->profesi_id) }}" class="formhorizontal">
                    @csrf
                    {!! method_field('PUT') !!}
                    <br>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Kategori Profesi</label>
                        <div class="col-10">
                            <select class="form-control" id="kategori_id" name="kategori_id" required>
                                <option value="">- Pilih Kategori Profesi -</option>
                                @foreach($kategori_profesi as $item)
                                    <option value="{{ $item->kategori_id }}" @if($item->kategori_id == $profesi->kategori_id) selected
                                    @endif>{{ $item->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Nama Profesi</label>
                        <div class="col-10">
                            <input type="text" class="form-control" id="nama_profesi" name="nama_profesi"
                                value="{{ old('nama_profesi', $profesi->nama_profesi) }}" required>
                            @error('nama_profesi')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Deskripsi</label>
                        <div class="col-10">
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi"
                                value="{{ old('deskripsi', $profesi->deskripsi) }}" required>
                            @error('deskripsi')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label"></label>
                        <div class="col-10">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('profesi') }}">Kembali</a>
                        </div>
                    </div>
                </form>
            @endempty
        </div>
    </div>
@endsection

@push('css')
@endpush
@push('js')
@endpush