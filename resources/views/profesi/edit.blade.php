@extends('layouts_dashboard.template')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div class="card card-outline card-primary">

        <div class="card-body">
            <div class="card-header">
                <h3 class="card-title">@lang('profession.edit_title')</h3>
                <div class="card-tools"></div>
            </div>
            @empty($profesi)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> @lang('profession.edit_alert.error')</h5>
                    @lang('profession.edit_alert.data_not_found')
                </div>

                <a href="{{ url('profesi') }}" class="btn btn-sm btn-default mt-2">@lang('profession.button.kembali')</a>
            @else
                <form method="POST" action="{{ url('/profesi/' . $profesi->profesi_id) }}" class="formhorizontal">
                    @csrf
                    {!! method_field('PUT') !!}
                    <br>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">@lang('profession.edit_field.profession_category')</label>
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
                        <label class="col-2 control-label col-form-label">@lang('profession.edit_field.profession_name')</label>
                        <div class="col-10">
                            <input type="text" class="form-control" id="nama_profesi" name="nama_profesi"
                                value="{{ old('nama_profesi', $profesi->nama_profesi) }}" required>
                            @error('nama_profesi')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">@lang('profession.edit_field.description')</label>
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
                            <button type="submit" class="btn btn-primary btn-sm">@lang('profession.button.simpan')</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('profesi') }}">@lang('profession.button.kembali')</a>
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