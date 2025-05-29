@extends('layouts_dashboard.template')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">@lang('professionCategory.edit_title')</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($kategori_profesi)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> @lang('professionCategory.edit_alert.error')</h5>
                    @lang('professionCategory.edit_alert.data_not_found')
                </div>

                <a href="{{ url('kategori-profesi') }}" class="btn btn-sm btn-default mt-2">@lang('professionCategory.button.kembali')</a>
            @else
                <form method="POST" action="{{ url('/kategori/' . $kategori_profesi->kategori_id) }}" class="form-horizontal">
                    @csrf
                    {!! method_field('PUT') !!}
                    <br>
                    <div class="form-group row">
                        <label class="col-md-2 control-label col-form-label">@lang('professionCategory.edit_field.category_code')</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="kode_kategori" name="kode_kategori"
                                value="{{ old('kode_kategori', $kategori_profesi->kode_kategori) }}" required>
                            @error('kode_kategori')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 control-label col-form-label">@lang('professionCategory.edit_field.category_name')</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori"
                                value="{{ old('nama_kategori', $kategori_profesi->nama_kategori) }}" required>
                            @error('nama_kategori')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
                            <button type="submit" class="btn btn-primary btn-sm">@lang('professionCategory.button.simpan')</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('kategori') }}">@lang('professionCategory.button.kembali')</a>
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