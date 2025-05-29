@extends('layouts_dashboard.template')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">@lang('alumni.edit_title')</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($alumni)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> @lang('alumni.edit_alert.error')</h5>
                    @lang('alumni.edit_alert.data_not_found')
                </div>

                <a href="{{ url('alumni') }}" class="btn btn-sm btn-default mt-2">@lang('alumni.button.kembali')</a>
            @else
                <form method="POST" action="{{ url('/alumni/' . $alumni->alumni_id) }}" class="form-horizontal">
                    @csrf
                    {!! method_field('PUT') !!}
                    <br>
                    <div class="form-group row">
                        <label class="col-md-2 control-label col-form-label">@lang('alumni.edit_field.prodi')</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="program_studi" name="program_studi"
                                value="{{ old('program_studi', $alumni->program_studi) }}" required>
                            @error('program_studi')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 control-label col-form-label">@lang('alumni.edit_field.nim')</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim', $alumni->nim) }}"
                                required>
                            @error('nim')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 control-label col-form-label">@lang('alumni.edit_field.nama')</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="{{ old('nama', $alumni->nama) }}" required>
                            @error('nama')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 control-label col-form-label">@lang('alumni.edit_field.email')</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="email" name="email"
                                value="{{ old('email', $alumni->email) }}" required>
                            @error('email')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 control-label col-form-label">@lang('alumni.edit_field.tanggal_lulus')</label>
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
                            <button type="submit" class="btn btn-primary btn-sm">@lang('alumni.button.simpan')</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('alumni') }}">@lang('alumni.button.kembali')</a>
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