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
    <link rel="stylesheet"
        href="{{ asset('TemplateAdmin/src/assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet"
        href="{{ asset('TemplateAdmin/src/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('TemplateAdmin/src/assets/css/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('TemplateAdmin/TEH.png') }}" />
    <!-- Additional CSS for form validation -->
    <link rel="stylesheet"
        href="{{ asset('TemplateAdmin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link src="{{ asset('TemplateAdmin/plugins/sweetalert2/sweetalert2.css') }}">
    </link>
    <link src="{{ asset('TemplateAdmin/plugins/sweetalert2/sweetalert2.min.css') }}">
    </link>
    <style>
        /* Custom styles for SweetAlert2 popups */
        .swal-popup-theme {
            border: 3px solid #4B49AC !important;
            border-radius: 10px !important;
        }

        .swal-popup-error {
            border: 3px solid #dc3545 !important;
            border-radius: 10px !important;
        }

        .swal-title {
            color: #4B49AC !important;
        }

        .swal-popup-error .swal-title {
            color: #dc3545 !important;
        }
        .error-text {
            color: #dc3545 !important;
        }
    </style>
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
                            <h4>Selamat datang! </h4>
                            <h6 class="fw-light">Silahkan login terlebih dahulu</h6>
                            <form action="{{ url('login') }}" method="POST" id="form-login" class="pt-3">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" id="username" name="username"
                                            class="form-control form-control-lg" placeholder="Username">
                                    </div>
                                    <small id="error-username" class="error-text text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="password" id="password" name="password"
                                            class="form-control form-control-lg" placeholder="Password">
                                    </div>
                                    <small id="error-password" class="error-text text-danger"></small>
                                </div>
                                <div class="mt-3 d-grid gap-2">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn">SIGN
                                        IN</button>
                                </div>
                                {{-- <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input" id="remember"> Keep me
                                            signed in
                                        </label>
                                    </div>
                                </div> --}}
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
    <script src="{{ asset('TemplateAdmin/src/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}">
    </script>
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
    {{-- <script src="{{ asset('TemplateAdmin/plugins/jquery/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('TemplateAdmin/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/plugins/sweetalert2/sweetalert2.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            // Pastikan SweetAlert terload
            if (typeof Swal === 'undefined') {
                console.error('SweetAlert2 not loaded!');
            }

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
                        dataType: 'json',
                        statusCode: {
                            200: function(response) {
                                // Handle successful responses
                                if (response.status) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Login Successful',
                                        text: 'Welcome to TraceEdu',
                                        confirmButtonColor: '#28a745'
                                    }).then(function() {
                                        window.location = response.redirect;
                                    });
                                }
                            },
                            401: function(response) {
                                // Handle unauthorized (login failed)
                                handleLoginError(response);
                            },
                            422: function(response) {
                                // Handle validation errors
                                handleLoginError(response);
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle other errors (network, server down, etc.)
                            console.error("AJAX error:", xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Connection Error',
                                text: 'Unable to connect to server. Please try again.',
                                confirmButtonColor: '#dc3545'
                            });
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

            // Fungsi untuk menangani error login
            function handleLoginError(xhrResponse) {
                try {
                    // Parse JSON response
                    const response = JSON.parse(xhrResponse.responseText);

                    // Clear previous errors
                    $('.error-text').text('');

                    // Show field errors if available
                    if (response.msgField) {
                        $.each(response.msgField, function(prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                    }

                    // Show error popup
                    setTimeout(function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: 'Invalid username or password',
                            confirmButtonColor: '#dc3545'
                        });
                    });
                } catch (e) {
                    // Fallback if JSON parsing fails
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: 'Invalid username or password',
                        confirmButtonColor: '#dc3545'
                    });
                }
            }
        });
    </script>
</body>

</html>
