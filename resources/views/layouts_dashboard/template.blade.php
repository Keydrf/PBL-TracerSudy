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
</body>

</html>