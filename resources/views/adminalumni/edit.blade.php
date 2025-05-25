@extends('layouts_dashboard.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Data Alumni</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($alumni)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>

                <a href="{{ url('alumni') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/alumni/' . $alumni->alumni_id) }}" class="form-horizontal">
                    @csrf
                    {!! method_field('PUT') !!}
                    <br>
                    <div class="form-group row">
                        <label class="col-md-2 control-label col-form-label">Program Studi</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="program_studi" name="program_studi"
                                value="{{ old('program_studi', $alumni->program_studi) }}" required>
                            @error('program_studi')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 control-label col-form-label">NIM</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim', $alumni->nim) }}"
                                required>
                            @error('nim')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 control-label col-form-label">Nama</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="{{ old('nama', $alumni->nama) }}" required>
                            @error('nama')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 control-label col-form-label">Kode OTP</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="kode_otp" name="kode_otp"
                                value="{{ old('kode_otp', $alumni->kode_otp) }}" required>
                            @error('kode_otp')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 control-label col-form-label">Tanggal Lulus</label>
                        <div class="col-md-10">
                            <input type="datetime-local" class="form-control" id="tanggal_lulus" name="tanggal_lulus"
                                value="{{ old('tanggal_lulus', \Carbon\Carbon::parse($alumni->tanggal_lulus)->format('Y-m-d\TH:i')) }}"
                                required>
                            @error('tanggal_lulus')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('alumni') }}">Kembali</a>
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