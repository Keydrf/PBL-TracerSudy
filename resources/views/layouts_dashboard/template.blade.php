<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />

    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('TemplateDashboard/assets/img/apple-icon.png')}}">

    <link rel="icon" type="image/png" href="{{asset('TemplateDashboard/assets/img/favicon.png')}}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Paper Dashboard 2 by Creative Tim
    </title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{asset('TemplateDashboard/assets/css/bootstrap.min.css')}}" rel="stylesheet" />

    <link href="{{asset('TemplateDashboard/assets/css/paper-dashboard.css?v=2.0.1')}}" rel="stylesheet" />
    <link href="{{asset('TemplateDashboard/assets/demo/demo.css')}}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('TemplateLP/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('TemplateLP/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link href="{{ asset('TemplateLP/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('TemplateLP/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('TemplateLP/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('TemplateLP/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('TemplateLP/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <link href="{{ asset('TemplateLP/assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('TemplateDashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('TemplateDashboard/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('TemplateDashboard/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('TemplateDashboard/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    @stack('css')
</head>

<body class="">
    <div class="wrapper ">
        @include('layouts_dashboard.sidebar')
        <div class="main-panel">
            @include('layouts_dashboard.header')
            <div class="content">
                <section class="content">
                    @yield('content')
                </section>

            </div>
            @include('layouts_dashboard.footer')
        </div>

    </div>
    <script src="{{asset('TemplateDashboard/assets/js/core/jquery.min.js')}}"></script>

    <script src="{{asset('TemplateDashboard/assets/js/core/popper.min.js')}}"></script>

    <script src="{{asset('TemplateDashboard/assets/js/core/bootstrap.min.js')}}"></script>

    <script src="{{asset('TemplateDashboard/assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <script src="{{asset('TemplateDashboard/assets/js/plugins/chartjs.min.js')}}"></script>
    <script src="{{asset('TemplateDashboard/assets/js/plugins/bootstrap-notify.js')}}"></script>
    <script src="{{asset('TemplateDashboard/assets/js/paper-dashboard.min.js?v=2.0.1')}}"
        type="text/javascript"></script>
    <script src="{{asset('TemplateDashboard/assets/demo/demo.js')}}"></script>

    

    <script>
        $(document).ready(function () {
            // Javascript method's body can be found in TemplateDashboard/assets/assets-for-demo/js/demo.js
            demo.initChartsPages();
        });
    </script>
    <script src="{{ asset('TemplateDashboard/dist/js/demo.js') }}"></script>
    <script src="{{ asset('TemplateDashboard/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('TemplateDashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('TemplateDashboard/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('TemplateDashboard/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('TemplateDashboard/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('TemplateDashboard/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('TemplateDashboard/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('TemplateDashboard/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('TemplateDashboard/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('TemplateDashboard/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('TemplateDashboard/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('TemplateDashboard/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    {{-- jquery-validation --}}
    <script src="{{ asset('TemplateDashboard/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('TemplateDashboard/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="{{ asset('TemplateDashboard/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        // Untuk mengirimkan token Laravel CSRF pada setiap request ajax
        $.ajaxSetup({ 
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            } 
        });
    </script>
    @stack('js')
</body>

</html>