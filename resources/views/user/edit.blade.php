@extends('layouts_dashboard.template') 
 
@section('content') 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <div class="card card-outline card-primary"> 
    
    <div class="card-body"> 
        <div class="card-header">
            <h3 class="card-title">@lang('user.edit_title')</h3>
            <div class="card-tools"></div>
        </div>
      @empty($user) 
        <div class="alert alert-danger alert-dismissible"> 
            <h5><i class="icon fas fa-ban"></i> @lang('user.edit_alert.error')</h5>             @lang('user.edit_alert.data_not_found') 
        </div> 
        
        <a href="{{ url('user') }}" class="btn btn-sm btn-default mt-2">@lang('user.button.kembali')</a>       @else 
        <form method="POST" action="{{ url('/user/'.$user->admin_id) }}" class="formhorizontal">           @csrf 
          {!! method_field('PUT') !!}  <!-- tambahkan baris ini untuk proses edit yang butuh method PUT --> 
          <br>
          <div class="form-group row"> 
            <label class="col-1 control-label col-form-label">@lang('user.edit_field.level')</label> 
            <div class="col-11"> 
              <select class="form-control" id="level_id" name="level_id" required> 
                <option value="">- Pilih Level -</option> 
                @foreach($level as $item) 
                  <option value="{{ $item->level_id }}" @if($item->level_id == $user->level_id) selected @endif>{{ $item->level_nama }}</option> 
                @endforeach 
              </select> 
              @error('level_id') 
                <small class="form-text text-danger">{{ $message }}</small> 
              @enderror 
            </div> 
          </div> 
          <div class="form-group row"> 
            <label class="col-1 control-label col-form-label">@lang('user.edit_field.username')</label> 
            <div class="col-11"> 
              <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}" required> 
              @error('username') 
                <small class="form-text text-danger">{{ $message }}</small> 
              @enderror 
            </div> 
          </div> 
          <div class="form-group row"> 
            <label class="col-1 control-label col-form-label">@lang('user.edit_field.name')</label> 
            <div class="col-11"> 
              <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required> 
              @error('nama') 
                <small class="form-text text-danger">{{ $message }}</small> 
              @enderror 
            </div> 
          </div> 
          <div class="form-group row"> 
            <label class="col-1 control-label col-form-label">@lang('user.edit_field.password.field')</label>             <div class="col-11"> 
              <input type="password" class="form-control" id="password" name="password">               @error('password') 
                <small class="form-text text-danger">{{ $message }}</small>               @else 
                <small class="form-text text-muted">@lang('user.edit_field.password.message')</small> 
              @enderror 
            </div> 
          </div> 
          <div class="form-group row"> 
            <label class="col-1 control-label col-form-label"></label> 
            <div class="col-11"> 
              <button type="submit" class="btn btn-primary btn-sm">@lang('user.button.simpan')</button> 
              <a class="btn btn-sm btn-default ml-1" href="{{ url('user') }}">@lang('user.button.kembali')</a> 
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
