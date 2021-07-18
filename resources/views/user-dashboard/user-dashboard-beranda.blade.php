@extends('layout.main-layout.main-layout')

@push('css')
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
<link href="{{ asset('asset\vendor\flipdown-master\dist\flipdown.min.css') }}" rel="stylesheet">
<link href="{{ asset('asset\css\layout-css\layout-css.css') }}" rel="stylesheet">
<link href="{{ asset('asset\css\layout-css\user-dashboard-layout.css') }}" rel="stylesheet">
@endpush

@section('navigation-wide')
    @include('user-dashboard.user-nav.top-nav-wide',['home' => 'active'])
@endsection

@section('navigation-small')
    @include('user-dashboard.user-nav.top-nav-small',['home' => 'active'])
@endsection

@section('content')

    <!-- PROFILE -->
    <div class="profile-wrapper p-2 animated slideInLeft">
        <!-- Card -->
        <div class="card z-depth-1" style="height:100%;">

        <!-- Card content -->
        <div class="card-body">

        <div class="container">
            <div class="row">
                <div class="col-5 d-flex justify-content-center align-items-center">
                    <img class="rounded-circle z-depth-1" src="{{ asset('asset\image\main_asset\no_pic_user.png') }}" alt="" style="width:100px; height:100px;">
                </div>

                <div class="col text-left mt-3">
                    <h5 style="font-size:18px;"><b>
                    @if(isset($jam))
                        @if($jam >= 0 && $jam < 10)
                            Selamat Pagi !
                        @elseif($jam >= 10 && $jam < 15)
                            Selamat Siang !
                        @elseif($jam >= 15 && $jam < 18)
                            Selamat Sore !
                        @elseif($jam >= 18 && $jam < 24)
                            Selamat Malam !
                        @else
                            Selamat Datang
                        @endif
                    @endif
                    </b></h5>
                    <h5 style="font-size:14px;">{{ strtoupper(Auth::user()->username) }}</h5>
                </div>
            </div>
        </div>

        <div class="container mt-3">
            <div class="row">
                <div class="col">
                    <!-- Default input -->
                    <label for="exampleForm1">No Pelajar TCI</label>
                    <input type="text" id="exampleForm1" class="form-control" value="{{ Auth::user()->nomor_pelajar_tci }}" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col mt-3">
                    <!-- Default input -->
                    <label for="exampleForm2">Nama Pelajar</label>
                    <input type="text" id="exampleForm2" class="form-control" value="{{ Auth::user()->name }}" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col mt-3">
                    <!-- Default input -->
                    <label for="exampleForm3">Email</label>
                    <input type="text" id="exampleForm3" class="form-control" value="{{ Auth::user()->email }}" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col mt-3">
                    <!-- Default input -->
                    <label for="exampleForm4">No HP.</label>
                    <input type="text" id="exampleForm4" class="form-control" value="{{ Auth::user()->phone_number }}" readonly>
                </div>
            </div>
        </div>

        </div>

        </div>
        <!-- Card -->
    </div>
    <!-- END PROFILE -->

    <!-- COUNTDOWN -->
    <div class="countdown animated slideInRight">
            <!-- Swiper -->
            <div class="swiper-container mySwiper pb-4 card m-2 z-depth-1">

                <div class="swiper-wrapper">
                    @if(isset($pendaftarans))
                        @if(count($pendaftarans) > 0)
                            @foreach($pendaftarans as $index => $pendaftaran)
                                <div class="swiper-slide d-flex justify-content-center align-items-center">
                                        <div class="m-3">
                                            <h5 class="text-center m-3">{{ $pendaftaran->nama_pendaftaran }}</h5>
                                            <div id="{{ 'flipdown'.$index }}" class="flipdown"></div>
                                        </div>
                                </div>
                            @endforeach
                        @else
                                <div class="swiper-slide d-flex justify-content-center align-items-center">
                                        <div class="m-3">
                                            <h5 class="text-center m-3">Belum ada pendaftaran course</h5>
                                            <div id="flipdown" class="flipdown"></div>
                                        </div>
                                </div>
                        @endif
                    @else
                                <div class="swiper-slide d-flex justify-content-center align-items-center">
                                        <div class="m-3">
                                            <h5 class="text-center m-3">Belum ada pendaftaran course</h5>
                                            <div id="flipdown" class="flipdown"></div>
                                        </div>
                                </div>
                    @endif
                </div>
                
                <div class="swiper-pagination"></div>

            </div>
    </div>
    <!-- END COUNTDOWN -->

    <!-- PENGUMUMAN -->
    <div class="pengumuman p-2 animated slideInUp" style="white-space: nowrap;">

        <div class="card card-pengumuman"  style="white-space: normal;">
            <!-- Card image -->
            <div class="view overlay">
                <img class="card-img-top" src="{{ asset('asset\image\main_asset\barong.png') }}"
                alt="Card image cap">
                <a href="#!">
                <div class="mask rgba-white-slight"></div>
                </a>
            </div>

            <!-- Card content -->
            <div class="card-body">

                <!-- Title -->
                <h4 class="card-title">Card title</h4>
                <!-- Text -->
                <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Id, illum earum. Autem voluptatem alias culpa fugiat vitae quasi quibusdam voluptates explicabo dicta quaerat quam incidunt odio sint deleniti, mollitia facilis.</p>
                <!-- Button -->

            </div>
        </div>

        <div class="card card-pengumuman"  style="white-space: normal;">
            <!-- Card image -->
            <div class="view overlay">
                <img class="card-img-top" src="{{ asset('asset\image\main_asset\barong.png') }}"
                alt="Card image cap">
                <a href="#!">
                <div class="mask rgba-white-slight"></div>
                </a>
            </div>

            <!-- Card content -->
            <div class="card-body">

                <!-- Title -->
                <h4 class="card-title">Card title</h4>
                <!-- Text -->
                <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Id, illum earum. Autem voluptatem alias culpa fugiat vitae quasi quibusdam voluptates explicabo dicta quaerat quam incidunt odio sint deleniti, mollitia facilis.</p>
                <!-- Button -->

            </div>
        </div>

        <div class="card card-pengumuman"  style="white-space: normal;">
            <!-- Card image -->
            <div class="view overlay">
                <img class="card-img-top" src="{{ asset('asset\image\main_asset\barong.png') }}"
                alt="Card image cap">
                <a href="#!">
                <div class="mask rgba-white-slight"></div>
                </a>
            </div>

            <!-- Card content -->
            <div class="card-body">

                <!-- Title -->
                <h4 class="card-title">Card title</h4>
                <!-- Text -->
                <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Id, illum earum. Autem voluptatem alias culpa fugiat vitae quasi quibusdam voluptates explicabo dicta quaerat quam incidunt odio sint deleniti, mollitia facilis.</p>
                <!-- Button -->

            </div>
        </div>
        
    </div>
    <!-- END PENGUMUMAN -->

@endsection

@push('js')
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script type="text/javascript" src="{{ asset('asset\vendor\flipdown-master\dist\flipdown.min.js') }}"></script>

<script>
    $(document).ready(function(){

        $('#navigation-button').click(function(){
            $('#navigation-block').toggleClass('active');
        })

        $('#navigation-button-close').click(function(){
            $('#navigation-block').toggleClass('active');
        })

        @if(isset($pendaftarans))
            @if(count($pendaftarans) > 0)
                @foreach($pendaftarans as $index => $pendaftaran)
                let flipdown{{ $index }} = new FlipDown({{ date_timestamp_get(date_create($pendaftaran->tanggal_selesai_pendaftaran)) }},'flipdown{{ $index }}');
                    flipdown{{ $index }}.start();
                @endforeach
            @else
                let flipdown = new FlipDown(0,'flipdown');
                    flipdown.start();
            @endif
        @else
            let flipdown = new FlipDown(0,'flipdown');
                flipdown.start();
        @endif
        
    });
</script>
<script>
      var swiper = new Swiper(".mySwiper", {
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
          delay: 3000,
          disableOnInteraction: false,
        },
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
      });
        // SWEETALERT2
            @if(Session::has('status'))
                Swal.fire({
                    icon:  @if(Session::has('icon')){!! '"'.Session::get('icon').'"' !!} @else 'question' @endif,
                    title: @if(Session::has('title')){!! '"'.Session::get('title').'"' !!} @else 'Oppss...'@endif,
                    text: @if(Session::has('message')){!! '"'.Session::get('message').'"' !!} @else 'Oppss...'@endif,
                });
            @endif
        // END
</script>

@endpush