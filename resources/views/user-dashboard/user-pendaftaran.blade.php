@extends('layout.main-layout.main-layout')

@push('css')
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
<link href="{{ asset('asset\css\user\user-pendaftaran.css') }}" rel="stylesheet">
@endpush

@section('navigation-wide')
    @include('user-dashboard.user-nav.top-nav-wide',['pendaftaran' => 'active'])
@endsection

@section('navigation-small')
    @include('user-dashboard.user-nav.top-nav-small')
@endsection

@section('content')
    <!-- CONTAINER -->
    <div class="container-fluid">
        <div class="row mt-3 animated slideInLeft position-relative" style="z-index:1000;">
            <!-- DROPDOWN -->
            <div class="col-12">
                <div class="btn-group dropright">
                    
                    <button type="button" class="btn">
                        @if(isset($pendaftaran->nama_pendaftaran))
                            {{$pendaftaran->nama_pendaftaran}}
                        @else
                            Pilih Pendaftaran
                        @endif
                    </button>
                    
                    <button type="button" class="btn btn-secondary dropdown-toggle px-3" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>

                    <div class="dropdown-menu">
                        @if(isset($semua_pendaftaran) && $semua_pendaftaran->count() > 0)
                            @foreach($semua_pendaftaran as $pendaftaran_lain)
                                @php
                                    $encrypt_id_pendaftaran = Crypt::encryptString($pendaftaran_lain->id);
                                @endphp
                                <a class="dropdown-item" href="{{ Route('user.pendaftaran',[$encrypt_id_pendaftaran]) }}">{{ $pendaftaran_lain->nama_pendaftaran }}</a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <!-- END DROPDOWN -->

            <!-- PENGUMUMAN -->
            <div class="col-6">

            </div>
            <!-- END PENGUMUMAN -->
        </div>

        <div class="row mb-3 animated slideInRight">
            <!-- KELAS -->
            <div class="col-12 col-lg-8 overflow-hidden">
                <div class="swiper-container mySwiper w-100 h-100">
                    <div class="swiper-pagination"></div>
                    <div class="swiper-wrapper">
                        @if(isset($pendaftaran->Kelas))
                            @if($pendaftaran->Kelas->count() > 0)
                                @foreach($pendaftaran->Kelas as $index => $kelas)
                                    <div class="swiper-slide mb-5 mt-3">
                                        <!-- Card -->
                                        <div class="card"
                                            @if($kelas->isLocked)
                                                style="opacity:.5;"
                                            @endif
                                        >

                                            <!-- Card image -->
                                            @if($kelas->logo_kelas != null)
                                                <img class="card-img-top" src="{{ asset('storage\image_kelas').'\\'.$kelas->logo_kelas }}" alt="Card image cap" style="height:150px;object-fit:cover;">
                                            @else
                                                <img class="card-img-top" src="{{ asset('storage\image_kelas\default.jpg') }}" alt="Card image cap" style="height:150px;object-fit:cover;">
                                            @endif

                                            <!-- Card content -->
                                            <div class="card-body">

                                                <!-- Title -->
                                                <h4 class="card-title m-0" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                                                    @if(isset($kelas->nama_kelas))
                                                        {{$kelas->nama_kelas}}
                                                    @else
                                                        Unknown Class
                                                    @endif
                                                </h4>
                                                <p class="card-text p-0">
                                                    @if(isset($kelas->hsk))
                                                        {{ strtoupper($kelas->hsk) }}
                                                    @endif
                                                </p>

                                                <p class="card-text p-0 text-center">
                                                    @if($kelas->isLocked)
                                                        <span class="rounded p-2 bg-danger z-depth-1 text-white">CLOSED</span>
                                                    @else
                                                    @if(isset($kelas->harga) && $kelas->isBerbayar)
                                                        <span class="rounded p-2 bg-primary z-depth-1 text-white">IDR {{ number_format($kelas->harga) }}</span>
                                                    @else
                                                        <span class="rounded p-2 bg-success z-depth-1 text-white">GRATIS</span>
                                                    @endif
                                                    @endif
                                                </p>
                                                
                                                <p class="card-text p-0 mb-0 mt-3">Kuota :</p>
                                                <h4>{{ $kelas->detail_kelas_count.'/'.$kelas->kuota }}</h4>
                                                @php
                                                    $persen = $kelas->detail_kelas_count/$kelas->kuota * 100;
                                                    $encrypt_kelas_id = Crypt::encryptString($kelas->id);
                                                @endphp
                                                <div class="progress border border-secondary mb-3" style="height:30px;">
                                                <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $persen }}%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>

                                                <div class="row m-0 p-0">
                                                    <div class="col-12 col-xl-6 m-xl-0 p-1">
                                                        <a href="{{ Route('user.jadwal.kelas',[$encrypt_kelas_id]) }}" class="btn-sm btn-block btn-secondary">JADWAL</a>
                                                    </div>
                                                    <form action="{{ Route('user.daftar.kelas') }}" method="POST" id="form-daftar-kelas-{{ $index }}">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="id_kelas" value="{{ $encrypt_kelas_id }}">
                                                    </form>
                                                    <div class="col-12 col-xl-6 m-xl-0 p-1">
                                                        <a class="btn-sm btn-block btn-primary text-white" onclick="daftarKelas({{ $index }},'{{ $kelas->nama_kelas }}')">DAFTAR</a>
                                                    </div>
                                                </div>
                                                

                                            </div>
                                        
                                        </div>
                                        <!-- Card -->
                                    </div>
                                @endforeach
                            @else
                                <div class="d-flex flex-column justify-content-center align-items-center w-100">
                                    <div>
                                        <img src="{{ asset('asset\image\main_asset\nodata.png') }}" alt="NO DATA" style="display:block;margin:auto;width:200px;">
                                    </div>

                                    <div>
                                        <h5 class="mt-5 text-center w-100">TIDAK ADA KELAS</h5>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="d-flex flex-column justify-content-center align-items-center w-100">
                                <div>
                                    <img src="{{ asset('asset\image\main_asset\nodata.png') }}" alt="NO DATA" style="display:block;margin:auto;width:200px;">
                                </div>

                                <div>
                                    <h5 class="mt-5 text-center w-100">TIDAK ADA KELAS</h5>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
            
            <!-- PENGUMUMAN -->
            <div class="col-12 col-lg-4">
                <div class="jumbotron overflow-hidden h-100 p-0">

                    <div class="text-center text-white p-2" style="background: rgb(89,15,16);background: linear-gradient(90deg, rgba(89,15,16,1) 0%, rgba(207,29,32,1) 100%);">
                        PENGUMUMAN
                    </div>
                    
                    <div class="swiper-container mySwiper2 h-100" id="pengumuman-responsive">
                        <div class="swiper-wrapper position-absolute" style="top:0px;left:0;right:0;bottom:10px;">
                            @if(isset($pendaftaran->PengumumanPendaftaran))
                                @if($pendaftaran->PengumumanPendaftaran->count() > 0)
                                    @foreach($pendaftaran->PengumumanPendaftaran as $pengumuman)
                                    <div class="swiper-slide overflow-auto pb-5 pl-1 pr-1 pt-1">
                                        {!! $pengumuman->pengumuman !!}
                                    </div>
                                    @endforeach
                                @else
                                    <div class="d-flex flex-column justify-content-center align-items-center w-100">
                                        <div>
                                            <img src="{{ asset('asset\image\main_asset\nodata.png') }}" alt="NO DATA" style="display:block;margin:auto;width:100px;">
                                        </div>

                                        <div>
                                            <h5 class="mt-5 text-center w-100">TIDAK ADA PENGUMUMAN</h5>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="d-flex flex-column justify-content-center align-items-center w-100">
                                    <div>
                                        <img src="{{ asset('asset\image\main_asset\nodata.png') }}" alt="NO DATA" style="display:block;margin:auto;width:100px;">
                                    </div>

                                    <div>
                                        <h5 class="mt-5 text-center w-100">TIDAK ADA PENGUMUMAN</h5>
                                    </div>
                                </div>
                            @endif
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
<script>
        $(document).ready(function(){

            $('#navigation-button').click(function(){
                $('#navigation-block').toggleClass('active');
            })

            $('#navigation-button-close').click(function(){
                $('#navigation-block').toggleClass('active');
            })
        });
    
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 10,
            freeMode: true,
            pagination: {
            el: ".swiper-pagination",
            clickable: true,
            },
            breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 10,
            },
            },
        });

        var swiper2 = new Swiper(".mySwiper2", {
            slidesPerView: 1,
            autoplay: true,
            spaceBetween: 10,
            freeMode: true,
            disableOnInteraction: true,
            pagination: {
            el: ".swiper-pagination2",
            clickable: true,
            },
        });

        function daftarKelas(index,nama_kelas){

            Swal.fire({
            title: 'Yakin mengikuti kelas '+nama_kelas+' ?',
            icon:'question',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Ikuti`,
            denyButtonText: `Batal`,
            footer:'Saya telah menyetujui semua  &nbsp; <a href="#">   persyaratan dan persetujuan</a>',
            }).then((result) => {
                
            if (result.isConfirmed) {
                $('#form-daftar-kelas-'+index).submit();
            } else if (result.isDenied) {
            }
            })
            
        }

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