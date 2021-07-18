@extends('layout.main-layout.main-layout')

@push('css')
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
<link href="{{ asset('asset\vendor\flipdown-master\dist\flipdown.min.css') }}" rel="stylesheet">
<link href="{{ asset('asset\css\user\user-pendaftaran.css') }}" rel="stylesheet">
@endpush

@section('navigation-wide')
    @include('user-dashboard.user-nav.top-nav-wide',['pendaftaran' => 'active'])
@endsection

@section('navigation-small')
    @include('user-dashboard.user-nav.top-nav-small')
@endsection

@section('content')

    <!-- DROPDOWN -->
    <div class="dropdown p-2 animated slideInLeft">
        <!-- Split button -->
        <div class="btn-group">
        <button type="button" class="btn">{{ strtoupper($pendaftaran->nama_pendaftaran) }}</button>
        <button type="button" class="btn dropdown-toggle px-3 bg-primary" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu">
            @if(isset($semua_pendaftaran))
                @foreach($semua_pendaftaran as $index => $pendaftaran_lain)
                    <a class="dropdown-item" href="{{ Route('user.pendaftaran',[$pendaftaran_lain->id]) }}">{{ $pendaftaran_lain->nama_pendaftaran }}</a>
                @endforeach
            @endif
        </div>
        </div>
    </div>
    <!-- END DROPDOWN -->

    <!-- KELAS -->
    <div class="kelas m-3 animated slideInUp">
        @if(isset($pendaftaran))
            @if(!$pendaftaran->Kelas->isEmpty())
                @foreach($pendaftaran->Kelas as $index => $kelas)
                    <!-- Card -->
                    <div class="card z-depth-2 mr-3 mb-3" @if($kelas->isLocked)style="opacity:0.6;"@endif>

                        <!-- Card image -->
                        <img class="card-img-top" src="{{ url('storage\image_kelas',[$kelas->logo_kelas]) }}" alt="Card image cap" style="height:200px;object-fit:cover;">

                        <!-- Card content -->
                        <div class="card-body text-center">

                            <!-- Title -->
                            <h4 class="card-title" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><a>{{ $kelas->nama_kelas }}</a></h4>
                            <!-- Text -->
                            <div class="row mt-3">

                                <div class="col">
                                    <img src="{{ url('storage\image_pengajar',[$kelas->Pengajar->foto_pengajar]) }}" alt="" class="img-thumbnail rounded-circle bg-secondary" style="width:50px;height:50px;object-fit:cover;">
                                </div>

                            </div>

                            <div class="row">
                                <div class="col">
                                    <b style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">{{ $kelas->Pengajar->nama_pengajar }}</b>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col" data-toggle="tooltip" title="HSK merupakan tingkatan dari kelas course ini">
                                    <p>{{ strtoupper($kelas->hsk) }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    @if($kelas->isLocked)
                                        <small class="badge badge-pill badge-danger" data-toggle="tooltip" title="Kelas ini ditutup oleh admin">CLOSED</small>
                                    @else
                                        <small class="badge badge-pill badge-success" data-toggle="tooltip" title="Kelas ini tersedia">OPEN</small>
                                    @endif

                                    @if($kelas->isBerbayar)
                                        <small class="badge badge-pill badge-success" data-toggle="tooltip" title="Kelas ini berbayar">BERBAYAR</small>
                                    @else
                                        <small class="badge badge-pill badge-warning" data-toggle="tooltip" title="Kelas ini Gratis">GRATIS</small>
                                    @endif
                                </div>
                            </div>

                            <div class="row m-3">
                                <div class="col">
                                    <input type="text" class="form-control font-weight-bold text-center border border-secondary" value="@if($kelas->isBerbayar){{ 'Rp.'.number_format($kelas->harga) }}@else GRATIS @endif" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    Kuota : {{$kelas->DetailKelas->count().'/'.$kelas->kuota}}
                                </div>
                            </div>

                            <div class="progress ml-3 mr-3 mb-3 border border-secondary">
                                <div class="progress-bar bg-secondary" role="progressbar" style="width:@if($kelas->kuota != 0){{ ($kelas->DetailKelas->count()/$kelas->kuota*100).'%' }};@endif"
                                >
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <a href="#" class="btn btn-outline-secondary waves-effect @if($kelas->isLocked) disabled @endif">Jadwal</a>
                                </div>
                                <div class="col">
                                    <a href="#" class="btn btn-success  @if($kelas->isLocked) disabled @endif">Ikuti</a>
                                </div>
                            </div>
                            <!-- Button -->

                        </div>

                    </div>
                @endforeach
            @else
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="col text-center">
                            <h4>BELUM ADA KELAS</h4>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col text-center">
                        <h4>BELUM ADA KELAS</h4>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- END KELAS -->
    
    <!-- PENGUMUMAN -->
    <div class="pengumuman animated slideInRight">
        <div class="swiper-container mySwiper jumbotron m-3 p-2 border-secondary">
        <h5 class="text-center text-white p-2" style="margin:-10px -10px 10px -10px;background: rgb(89,15,16);background: linear-gradient(90deg, rgba(89,15,16,1) 0%, rgba(207,29,32,1) 100%);">PENGUMUMAN</h5>

            <div class="swiper-wrapper mb-5" style="height:50vh;overflow-x:hidden;">

                <div class="swiper-slide">
                            
                            <!-- CARD -->
                            <div class="card-pengumuman">


                            </div>
                            <!-- END CARD -->

                </div>

                <div class="swiper-slide d-flex justify-content-center align-items-center">
                        a
                            
                </div>

                <div class="swiper-slide d-flex justify-content-center align-items-center">
                               
                        b
                </div>
            </div>
            
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <!-- END PENGUMUMAN -->

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
    </script>
<script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 30,
            centeredSlides: true,
            autoplay: {
            delay: 3000,
            disableOnInteraction: true,
            },
            pagination: {
            el: ".swiper-pagination",
            clickable: true,
            }
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