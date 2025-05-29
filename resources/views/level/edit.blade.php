@extends('layouts_dashboard.template') 
 
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <div class="card card-outline card-primary"> 
    
    <div class="card-body"> 
        <div class="card-header">
            <h3 class="card-title">@lang('level.edit_title')</h3>
            <div class="card-tools"></div>
        </div>
      @empty($level) 
        <div class="alert alert-danger alert-dismissible"> 
            <h5><i class="icon fas fa-ban"></i> @lang('level.edit_alert.error')</h5>             @lang('level.edit_alert.data_not_found') 
        </div> 
        
        <a href="{{ url('level') }}" class="btn btn-sm btn-default mt-2">@lang('level.button.kembali')</a>       @else 
        <form method="POST" action="{{ url('/level/'.$level->level_id) }}" class="formhorizontal">           @csrf 
          {!! method_field('PUT') !!}  <!-- tambahkan baris ini untuk proses edit yang butuh method PUT --> 
          <br>
          <div class="form-group row"> 
            <label class="col-1 control-label col-form-label">@lang('level.edit_field.kode')</label> 
            <div class="col-11"> 
              <input type="text" class="form-control" id="level_kode" name="level_kode" value="{{ old('level_kode', $level->level_kode) }}" required> 
              @error('level_kode') 
                <small class="form-text text-danger">{{ $message }}</small> 
              @enderror 
            </div> 
          </div> 
          <div class="form-group row"> 
            <label class="col-1 control-label col-form-label">@lang('level.edit_field.nama')</label> 
            <div class="col-11"> 
              <input type="text" class="form-control" id="level_nama" name="level_nama" value="{{ old('level_nama', $level->level_nama) }}" required> 
              @error('level_nama') 
                <small class="form-text text-danger">{{ $message }}</small> 
              @enderror 
            </div> 
          </div> 
          
          <div class="form-group row"> 
            <label class="col-1 control-label col-form-label"></label> 
            <div class="col-11"> 
              <button type="submit" class="btn btn-primary btn-sm">@lang('level.button.simpan')</button> 
              <a class="btn btn-sm btn-default ml-1" href="{{ url('level') }}">@lang('level.button.kembali')</a> 
            </div> 
          </div> 
        </form> 
      @endempty 
    </div> 
  </div> 
@endsection 
 
@push('css') 
@endpush 
@push('js') @endpush 
