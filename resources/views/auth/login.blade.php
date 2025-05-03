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
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/css/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('TemplateAdmin/src/assets/images/favicon2.png') }}" />
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
                  <img src="{{ asset('TemplateAdmin/src/assets/images/logo.svg') }}" alt="logo">
                </div>
                <h4>Hello! let's get started</h4>
                <h6 class="fw-light">Sign in to continue.</h6>
                <form action="{{ url('login') }}" method="POST" id="form-login" class="pt-3">
                  @csrf
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" id="username" name="username" class="form-control form-control-lg" placeholder="Username">
                    </div>
                    <small id="error-username" class="error-text text-danger"></small>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Password">
                    </div>
                    <small id="error-password" class="error-text text-danger"></small>
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <button type="submit" class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn">SIGN IN</button>
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input" id="remember"> Keep me signed in
                      </label>
                    </div>
                  </div>
                  {{-- <div class="text-center mt-4 fw-light">
                    Don't have an account? <a href="{{ route('register') }}" class="text-primary">Create</a>
                  </div> --}}
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('TemplateAdmin/src/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/src/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('TemplateAdmin/src/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/src/assets/js/template.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/src/assets/js/settings.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/src/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/src/assets/js/todolist.js') }}"></script>
    <!-- endinject -->
    
    <!-- Additional JS for form validation -->
    {{-- <script src="{{ asset('TemplateAdmin/src/plugins/jquery/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('TemplateAdmin/src/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/src/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/src/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
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
            $("#form-login").validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 4,
                        maxlength: 20
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 20
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
                                    window.location = response.redirect;
                                });
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
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