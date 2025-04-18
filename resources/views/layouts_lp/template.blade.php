<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Index - eNno Bootstrap Template</title>
    <meta name="description" content="">

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


    @stack('css')

    </head>

<body class="index-page">

    @include('layouts_lp.header')

    <main class="main">

        @include('layouts_lp.landingpage')

    </main>

    @include('layouts_lp.footer')

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('TemplateLP/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('TemplateLP/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('TemplateLP/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('TemplateLP/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('TemplateLP/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('TemplateLP/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('TemplateLP/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('TemplateLP/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <script src="{{ asset('TemplateLP/assets/js/main.js') }}"></script>
    
</body>

</html>