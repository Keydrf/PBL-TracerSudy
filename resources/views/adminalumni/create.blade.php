@extends('layouts_dashboard.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Tambah Data Alumni</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('alumni') }}" class="form-horizontal">
                @csrf
                
                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label">Program Studi</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="program_studi" name="program_studi"
                            value="{{ old('program_studi') }}" required>
                        @error('program_studi')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label">NIM</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="nim" name="nim"
                            value="{{ old('nim') }}" required>
                        @error('nim')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label">Nama</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="{{ old('nama') }}" required>
                        @error('nama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label">Kode OTP</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="kode_otp" name="kode_otp"
                            value="{{ old('kode_otp') }}" required>
                        @error('kode_otp')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label">Tanggal Lulus</label>
                    <div class="col-md-10">
                        <input type="datetime-local" class="form-control" id="tanggal_lulus" name="tanggal_lulus"
                            value="{{ old('tanggal_lulus') }}" required>
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
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush