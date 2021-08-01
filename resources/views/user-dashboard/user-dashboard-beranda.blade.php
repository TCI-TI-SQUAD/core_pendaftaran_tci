@extends('layout.main-layout.main-layout')

@push('css')
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
<link href="{{ asset('asset\vendor\flipdown-master\dist\flipdown.min.css') }}" rel="stylesheet">
<link href="{{ asset('asset\css\layout-css\user-dashboard-layout.css') }}" rel="stylesheet">
@endpush

@section('navigation-wide')
    @include('user-dashboard.user-nav.top-nav-wide',['home' => 'active'])
@endsection

@section('navigation-small')
    @include('user-dashboard.user-nav.top-nav-small',['home' => 'active'])
@endsection

@section('content')
    <!-- CONTAINER -->
    <div class="container-fluid h-100">
        <div class="row">
            <div class="col-12 col-lg-6 p-2 m-0">
                <div class="jumbotron p-0 m-0">
                    <div class="row">
                        <div class="col-12 col-md-3 p-3 text-center">
                            <img src="{{ asset('storage\image_users\no_pic_user.png') }}" class="img-thumbnail rounded-circle" alt="IMAGE USERS" style="width:100px;display:block;margin:auto;object-fit:cover;">
                        </div>
                        <div class="col-12 m-md-0 col-md-7 p-3">
                            <div class="row">
                                <div class="col-12 text-center text-md-left" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                                    @if(isset($jam))
                                        @if($jam >= 0 && $jam < 10)
                                            <span class="font-weight-bold">SELAMAT PAGI</span>
                                        @elseif($jam >= 10 && $jam < 14)
                                            <span class="font-weight-bold">SELAMAT SIANG</span>
                                        @elseif($jam >= 14 && $jam < 18)
                                            <span class="font-weight-bold">SELAMAT SORE</span>
                                        @elseif($jam >= 18 && $jam <= 24)
                                            <span class="font-weight-bold">SELAMAT MALAM</span>
                                        @else
                                            <span class="font-weight-bold">SELAMAT DATANG</span>
                                        @endif
                                    @endif
                                </div>
                                <div class="col-12 text-center text-md-left" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                                    {{ strtoupper(Auth::user()->name) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-12 pl-4 pr-4">
                            <label class="p-0 m-0">Nama</label>
                            <input type="text" class="form-control m-0" value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="col-12 pl-4 pr-4 mt-3">
                            <label class="p-0 m-0">Nomor Pelajar TCI</label>
                            <input type="text" class="form-control m-0" value="{{ Auth::user()->nomor_pelajar_tci }}" readonly>
                        </div>
                        <div class="col-12 pl-4 pr-4 mt-3">
                            <label class="p-0 m-0">Status</label>
                            <input type="text" class="form-control m-0" value="{{ strtoupper(Auth::user()->status) }}" readonly>
                        </div>
                        <div class="col-12 pl-4 pr-4 mt-3">
                            <label class="p-0 m-0">Instansi / Universitas</label>
                            <input type="text" class="form-control m-0" value="{{ strtoupper(Auth::user()->getInstansiName()) }}" readonly>
                        </div>
                        <div class="col-12 pl-4 pr-4 mt-3">
                            <label class="p-0 m-0">E-mail</label>
                            <input type="text" class="form-control m-0" value="{{ Auth::user()->email }}" readonly>
                        </div>
                        <div class="col-12 pl-4 pr-4 mt-3 mb-4">
                            <label class="p-0 m-0">No Hp</label>
                            <input type="text" class="form-control m-0" value="{{ Auth::user()->phone_number }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 p-0 d-flex flex-column justify-content-center align-items-center">
                
                    <div class="col p-0 m-0" id="countdown">
                        <div class="swiper-container mySwiper h-100 p-0">
                            <div class="swiper-wrapper p-0 m-0" style="position: absolute;left: 0;top: 0;right:0;bottom:0;">
                                @if(isset($pendaftarans))
                                    @if($pendaftarans->count() > 0)
                                        @foreach($pendaftarans as $index => $pendaftaran)
                                            <div class="swiper-slide d-flex flex-column justify-content-center">
                                                <div>
                                                <h5 class="text-center"><b>{{ $pendaftaran->nama_pendaftaran }}</b></h5>
                                                <div id="flipdown{{ $index }}" class="flipdown m-auto"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                
                
                    <div class="col position-relative p-0 m-0" style="left:0;right:0;bottomn:0;top:0;" id="pengumuman">
                        <div class="swiper-container mySwiper h-100 p-0">
                            <div class="swiper-wrapper p-0 m-0" style="position: absolute;left: 0;top: 0;right:0;bottom:0;z-index:19999;">
                                <div class="swiper-slide d-flex flex-column p-3">
                                    @if(isset($pengumuman_global))
                                        @if($pengumuman_global->count())
                                            @foreach($pengumuman_global as $index => $pengumuman)
                                                <h5 class="text-center font-weight-bold text-white" style="background: rgb(89,15,16);background: linear-gradient(90deg, rgba(89,15,16,1) 0%, rgba(207,29,32,1) 100%);">PENGUMUMAN SISTEM {{ $index+1 }}</h5>
                                                <div class="card overflow-auto p-2">
                                                    {!! $pengumuman->pengumuman !!}
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="card overflow-auto p-2">
                                                TIDAK ADA PENGUMUMAN
                                            </div>
                                        @endif
                                    @else
                                        <div class="card overflow-auto p-2">
                                            TIDAK ADA PENGUMUMAN
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                
            </div>
        </div>
    </div>
    <!-- END CONTAINER -->

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