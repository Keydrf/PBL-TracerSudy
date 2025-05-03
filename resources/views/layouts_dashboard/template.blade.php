<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>TraceEdu</title>
  <!-- plugins:css -->
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.3/dist/sweetalert2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="{{ asset('TemplateAdmin/dist/assets/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('TemplateAdmin/dist/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('TemplateAdmin/dist/assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('TemplateAdmin/dist/assets/vendors/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('TemplateAdmin/dist/assets/vendors/typicons/typicons.css') }}">
  <link rel="stylesheet"
    href="{{ asset('TemplateAdmin/dist/assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('TemplateAdmin/dist/assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet"
    href="{{ asset('TemplateAdmin/dist/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('TemplateAdmin/TEH.png') }}" />
  <!-- Plugin css for this page -->
  <link rel="stylesheet"
    href="{{ asset('TemplateAdmin/dist/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('TemplateAdmin/dist/assets/js/select.dataTables.min.css') }}">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('TemplateAdmin/dist/assets/css/style.css') }}">
  <!-- endinject -->

  @stack('css')
</head>

<body class="with-welcome-text">
  <div class="container-scroller">
    
    <!-- partial:partials/_navbar.html -->
    @include('layouts_dashboard.header')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      @include('layouts_dashboard.sidebar')
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <section class="content">
            @yield('content')
          </section>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        @include('layouts_dashboard.footer')
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->

  <script src="{{ asset('TemplateAdmin/dist/assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script
    src="{{ asset('TemplateAdmin/dist/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="{{ asset('TemplateAdmin/dist/assets/vendors/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('TemplateAdmin/dist/assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{ asset('TemplateAdmin/dist/assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('TemplateAdmin/dist/assets/js/template.js') }}"></script>
  <script src="{{ asset('TemplateAdmin/dist/assets/js/settings.js') }}"></script>
  <script src="{{ asset('TemplateAdmin/dist/assets/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('TemplateAdmin/dist/assets/js/todolist.js') }}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{ asset('TemplateAdmin/dist/assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
  <script src="{{ asset('TemplateAdmin/dist/assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('TemplateAdmin/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('TemplateAdmin/plugins/jquery-validation/additional-methods.min.js') }}"></script>
  {{-- <!-- <script src="{{ asset('TemplateAdmin/dist/assets/js/Chart.roundedBarCharts.js') }}"></script> --> --}}
  <!-- End custom js for this page-->


  <!-- SweetAlert2 -->
  <!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.3/dist/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
  <script>
    // Untuk mengirimkan token Laravel CSRF pada setiap request ajax
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  </script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
  @stack('js')
</body>

</html>