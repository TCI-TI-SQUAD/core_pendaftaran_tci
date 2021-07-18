<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    <link href="{{ asset('asset\css\auth-page\user-login-template.css') }}" rel="stylesheet">
    <link href="{{ asset('asset\vendor\mdbootstrap\css\bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset\vendor\mdbootstrap\css\mdb.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset\vendor\fontawesome\css\all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css\app.css') }}" rel="stylesheet">
    @stack('top_source')
</head>
<body>
    <!-- WRAPPER -->
    <div class="wrapper">
        <div class="pamflet">
            <img class="pamflet-image" src="{{ asset('asset\image\user-login\bg-min-2.jpg') }}" alt="gagal download gambar"/>
            <div class="logo-wrapper">
                <img src="{{ asset('asset\image\main_asset\logo tci.png') }}" alt="">
                <p class="text-center mt-3" style="color: gold;">乌达亚纳大学旅游孔子学院</p>
                <p class="text-center text-white">TOURISM CONFUCIUS INSTITUTE UDAYANA UNIVERSITY</p>
            </div>
        </div>
        <div class="form">
            @yield('form')
        </div>
    </div>
    <!-- END WRAPPER -->

    <script type="text/javascript" src="{{ asset('asset\vendor\mdbootstrap\js\jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset\vendor\mdbootstrap\js\popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset\vendor\mdbootstrap\js\bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset\vendor\mdbootstrap\js\mdb.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset\vendor\fontawesome\js\all.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js\app.js') }}"></script>
    @stack('bottom_source')
</body>
</html>