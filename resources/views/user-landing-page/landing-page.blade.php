@extends('layout.main-layout.main-layout')

@push('css')
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
<link href="{{ asset('asset\vendor\flipdown-master\dist\flipdown.min.css') }}" rel="stylesheet">
<link href="{{ asset('asset\css\layout-css\layout-css.css') }}" rel="stylesheet">
<link href="{{ asset('asset\css\lading-page\user-landing-page.css') }}" rel="stylesheet">
@endpush

@section('navigation-small')
    @include('user-landing-page.user-landing-page-nav.user-landing-page-nav-small',['home' => 'active'])
@endsection

@section('navigation-wide')
    @include('user-landing-page.user-landing-page-nav.user-landing-page-nav-wide',['home' => 'active'])
@endsection

@section('content')
            <div class="big-image animated slideInLeft"> 
                <img src="{{ asset('asset\image\landing-page\lampion.webp') }}" alt="lampion.webp" class="z-depth-2">
            </div>

            <div class="real-content animated slideInRight">
                <div>
                    <h3><span style="color:#4B0C0D;font-weight:bold;">Belajar Bahasa Mandarin</span> Menjadi Mudah <span style="color:#4B0C0D;font-weight:bold;">Bersama Kami</span></h3>
                </div>

                <div class="swiper-container mySwiper pb-4">

                    <div class="swiper-wrapper">
                        @if(isset($pendaftarans))
                            @if(count($pendaftarans) > 0)
                                @foreach($pendaftarans as $index => $pendaftaran)
                                    <div class="swiper-slide d-flex justify-content-center align-items-center">
                                            <div class="m-3">
                                                <h5 class="text-center m-3"><b>{{ $pendaftaran->nama_pendaftaran }}</b></h5>
                                                <div id="flipdown{{ $index }}" class="flipdown"></div>
                                            </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="swiper-slide d-flex justify-content-center align-items-center">
                                        <div class="m-3">
                                            <h5 class="text-center m-3"><b>Belum Ada Pendaftaran</b></h5>
                                        </div>
                                </div>
                            @endif
                        @else
                            <div class="swiper-slide d-flex justify-content-center align-items-center">
                                    <div class="m-3">
                                        <h5 class="text-center m-3"><b>Belum Ada Pendaftaran</b></h5>
                                    </div>
                            </div>
                        @endif
                    </div>

            @if(isset($pendaftarans))
                @if(count($pendaftarans) > 0)
                    <div class="swiper-pagination"></div>
                @endif
            @endif

                </div>

            </div>
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
                @endif
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