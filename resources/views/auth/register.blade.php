<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TraceEdu</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/css/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('TemplateAdmin/TEH.png') }}" />
    <!-- Additional CSS for form validation -->
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                <div class="brand-logo">
                  <img src="{{ asset('TemplateAdmin/TEDB1.PNG') }}" alt="logo">
                </div>
                <h4>Hello! let's get started</h4>
                <h6 class="fw-light">Create your account to continue.</h6>
                <form action="{{ route('register') }}" method="POST" id="form-register" class="pt-3">
                  @csrf
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" id="username" name="username" class="form-control form-control-lg" placeholder="Username" value="{{ old('username') }}">
                    </div>
                    <small id="error-username" class="error-text text-danger"></small>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" id="nama" name="nama" class="form-control form-control-lg" placeholder="Full Name" value="{{ old('nama') }}">
                    </div>
                    <small id="error-nama" class="error-text text-danger"></small>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Password">
                    </div>
                    <small id="error-password" class="error-text text-danger"></small>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-lg" placeholder="Confirm Password">
                    </div>
                  </div>
                  <div class="form-group">
                    <select name="level_id" class="form-control form-control-lg">
                      <option value="">Select Role</option>
                      @foreach($levels as $level)
                        <option value="{{ $level->level_id }}" {{ old('level_id') == $level->level_id ? 'selected' : '' }}>
                          {{ $level->level_nama }}
                        </option>
                      @endforeach
                    </select>
                    <small id="error-level_id" class="error-text text-danger"></small>
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <button type="submit" class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn">REGISTER</button>
                  </div>
                  <div class="text-center mt-4 fw-light">
                    Already have an account? <a href="{{ route('login') }}" class="text-primary">Login</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts sama dengan login.blade.php -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('TemplateAdmin/src/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/src/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/src/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $("#form-register").validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 4,
                        maxlength: 20,
                        remote: {
                            url: "{{ route('check.username') }}",
                            type: "post"
                        }
                    },
                    nama: {
                        required: true,
                        maxlength: 100
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    },
                    level_id: {
                        required: true
                    }
                },
                messages: {
                    username: {
                        remote: "Username sudah digunakan"
                    },
                    password_confirmation: {
                        equalTo: "Password confirmation tidak sama"
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                }).then(function() {
                                    window.location.href = "{{ url('/dashboard') }}";
                                });
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                $('.error-text').text('');
                                $.each(xhr.responseJSON.errors, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
  </body>
</html>