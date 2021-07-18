<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    <link href="{{ asset('asset\vendor\mdbootstrap\css\bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset\vendor\mdbootstrap\css\main.css') }}" rel="stylesheet">
    <link href="{{ asset('asset\vendor\fontawesome\css\all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css\app.css') }}" rel="stylesheet">
    @stack('css')

</head>
<body>
    <!-- NAVIGATION BLOCK -->
    <div class="navigation-block" id="navigation-block">
            @yield('navigation-small')
            <div class="navigation-block-child mt-5" id="navigation-button-close">
                    <div class="text-center text-danger" style="margin:10px;width:50px;"><i class="fas fa-chevron-right"></i></div>
                    <div style="flex-grow:2;margin:10px;" class="text-danger">Close</div>
            </div>
    </div>

    <!-- WRAPPER -->
    <div class="wrapper">

        <!-- NAVIGATION-->
        <div class="nav z-depth-1">
            <!-- LOGO WRAPPER -->
            <div class="logo-wrapper">
                <img src="{{ asset('asset\image\main_asset\logo.png') }}" alt="">
            </div>
            <!--  -->
            <!-- NAV WRAPPER -->
            <div class="nav-wrapper">
                <!-- FULL MENU WHEN SCREEN > 1000PX -->
                <ul id="nav-media-wide">
                    @yield('navigation-wide')
                </ul>

                <!-- HAMBURGER MENU WHEN SCREEN < 1000PX -->
                <ul id="nav-media-small">
                    <li id="navigation-button">
                        <i class="fas fa-bars"></i>
                    </li>
                </ul>

            </div>
        </div>
        <!-- END NAVIGATION -->

        <!-- CONTENT -->
        <div class="content">
            @yield('content')
        </div>
        <!-- END CONTENT -->

        <!-- FOOTER -->
        <div class="footer" style='background-image: url("{{ url("") }}/asset/image/main_asset/footer.png")''>
            <div class="footer-content">

                <div class="logo-wrapper">
                    <div class="text-center">
                        <img src="{{ asset('asset\image\main_asset\logo tci.png') }}" alt="">
                        <p class="text-center mt-3" style="color: gold;">乌达亚纳大学旅游孔子学院</p>
                        <p class="text-center text-white">TOURISM CONFUCIUS INSTITUTE UDAYANA UNIVERSITY</p>
                    </div>
                </div>

                <div class="contact text-white">
                    <div>
                        <h5 class="mb-3 text-center">Contact Us</h5>
                    </div>
                    <div>
                        <small><i class="far fa-building"></i> Tourism Confucius Institute Udayana University</small>
                    </div>
                    <div class="mt-2">
                        <small><i class="fas fa-map-marker-alt"></i> Gedung Argokompleks Lantai IV Kantor Tourism 
                        Confucius Institute, JL. P.B. Sudirman, Dauh Puri Klod, 
                        Kec. Denpasar Barat 80234</small>
                    </div>
                    <div class="mt-2">
                        <small><i class="far fa-building"></i> Tourism Confucius Institute Udayana University</small>
                    </div>
                    <div class="mt-2">
                        <small><i class="far fa-envelope"></i> Email: tci.unud.ac.id</small>
                    </div>
                    <div class="mt-2">
                        <small><i class="fas fa-phone-alt"></i> Phone: +62 361 4722331</small>
                    </div>
                    <div class="mt-2">
                        <small><i class="fas fa-fax"></i> Fax: +62 361 4722331</small>
                    </div>
                </div>

                <div class="social-media text-white">
                    <div>
                        <h5 class="mb-3 text-center">Social Media</h5>
                    </div>
                    @if(isset($social_medias))
                        @foreach($social_medias as $social_media)
                            <div class="mt-2" data-toggle="tooltip" title="{{ $social_media->keterangan }}" href="{{ $social_media->link }}">
                                <a target="_blank" href="{{ $social_media->link }}" class="text-white">
                                    <img src="{{ url('asset\image\social-media',[$social_media->social_media_image]) }}" alt="" style="margin:auto;display:inline-block;width:20px;height:20px">
                                    <small style="display:inline-block">{{ $social_media->nama_social_media }}</small>
                                </a>
                            </div>
                        @endforeach
                    @endif
                    
                </div>

                <div class="copyright text-white text-center mt-3" style="background-color:#5e0411;">
                    <small>&copy; Richard & Alsan Tech 2021 | All Right Reserved</small>
                </div>
                
            </div>
        </div>
        <!-- END FOOTER -->

    </div>
    <!-- END WRAPPER -->

    <script type="text/javascript" src="{{ asset('asset\vendor\mdbootstrap\js\jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset\vendor\mdbootstrap\js\popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset\vendor\mdbootstrap\js\bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset\vendor\mdbootstrap\js\mdb.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset\vendor\fontawesome\js\all.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js\app.js') }}"></script>
    <script>
        $(document).ready(function(){
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        });
    </script>
    @stack('js')
</body>
</html>