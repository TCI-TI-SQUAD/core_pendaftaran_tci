@extends('layout.main-layout.main-layout')

@push('css')
<link href="{{ asset('asset\css\user\user-pembayaran.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('plugins\swiper\swiper-bundle.min.css') }}">
@endpush

@section('navigation-wide')
    @include('user-dashboard.user-nav.top-nav-wide',['kelas_saya' => 'active'])
@endsection

@section('navigation-small')
    @include('user-dashboard.user-nav.top-nav-small',['kelas_saya' => 'active'])
@endsection

@section('content')
    <!-- CONTAINER -->
        <div class="container p-0">
            <div class="row">
                <div class="col-sm-12 col-lg-4 order-2 order-lg-1 animated slideInLeft ">
                    <div class="jumbotron m-3 p-0">
                        <h5 class="text-white text-center p-2" style="background: rgb(89,15,16);background: linear-gradient(90deg, rgba(89,15,16,1) 0%, rgba(207,29,32,1) 100%);">HSK ANDA</h5>
                        <!-- Vertical Steppers -->
                        <div class="row p-0 m-0">
                            <div class="col-md-12">

                                <!-- Stepers Wrapper -->
                                <ul class="stepper stepper-vertical pl-5">

                                <li class="">
                                    <a href="#!">
                                    <span class="circle bg-secondary">1</span>
                                    <span class="label text-dark">Pemula</span>
                                    </a>
                                </li>

                                <li class="">
                                    <a href="#!">
                                    <span class="circle bg-secondary">2</span>
                                    <span class="label text-dark">HSK 1</span>
                                    </a>
                                </li>

                                <li class="">
                                    <a href="#!">
                                    <span class="circle">3</span>
                                    <span class="label text-dark">HSK 2</span>
                                    </a>
                                </li>

                                <li class="">
                                    <a href="#!">
                                    <span class="circle">4</span>
                                    <span class="label text-dark">HSK 3</span>
                                    </a>
                                </li>

                                <li class="">
                                    <a href="#!">
                                    <span class="circle">5</span>
                                    <span class="label text-dark">HSK 4</span>
                                    </a>
                                </li>

                                <li class="">
                                    <a href="#!">
                                    <span class="circle">6</span>
                                    <span class="label text-dark">HSK 5</span>
                                    </a>
                                </li>

                                <li class="">
                                    <a href="#!">
                                    <span class="circle">7</span>
                                    <span class="label text-dark">HSK 6</span>
                                    </a>
                                </li>
                                </ul>
                                <!-- /.Stepers Wrapper -->

                            </div>
                        </div>

                    <!-- /.Vertical Steppers -->
                    </div>
                </div>

                <div class="col-sm-12 col-lg-8 order-1 order-lg-2">
                    <div class="m-0 p-0 row">
                        <div class="col-12 pt-1 pl-1 m-3 animated slideInRight">
                            <h5 class="font-weight-bold">KELAS SAYA</h5>
                        </div>
                        <div class="col-12 p-0 text-center animated slideInRight">
                            <a href="{{ route('user.kelas.saya',['semua']) }}" type="button" class="btn btn-sm
                                @if(isset($filter))
                                    @if($filter == 'semua')
                                        btn-secondary
                                    @else
                                        btn-grey
                                    @endif
                                @else
                                btn-grey
                                @endif
                            " style="border-radius:50px;width:140px">Semua</a>
                            <a href="{{ route('user.kelas.saya',['menunggu']) }}" type="button" class="btn btn-sm
                                @if(isset($filter))
                                    @if($filter == 'menunggu')
                                        btn-secondary text-white
                                    @else
                                        btn-grey
                                    @endif
                                @else
                                    btn-grey
                                @endif
                            " style="border-radius:50px;width:140px">Menunggu</a>
                            <a href="{{ route('user.kelas.saya',['dibatalkan']) }}" type="button" class="btn btn-sm
                                @if(isset($filter))
                                    @if($filter == 'dibatalkan')
                                        btn-secondary text-white
                                    @else
                                        btn-grey
                                    @endif
                                @else
                                    btn-grey
                                @endif
                            " style="border-radius:50px;width:140px">Dibatalkan</a>
                            <a href="{{ route('user.kelas.saya',['selesai']) }}" type="button" class="btn btn-sm
                                @if(isset($filter))
                                    @if($filter == 'selesai')
                                        btn-secondary text-white
                                    @else
                                        btn-grey
                                    @endif
                                @else
                                    btn-grey
                                @endif
                            " style="border-radius:50px;width:140px">Selesai</a>
                        </div>
                        <div class="col-12 mt-3 p-0 animated slideInUp">
                            <!-- Swiper -->
                            <div class="swiper-container mySwiper p-0">
                                <div class="swiper-wrapper p-0">
                                    @if(isset($detail_kelas))
                                        @if(count($detail_kelas) > 0)
                                            @foreach($detail_kelas as $detail)
                                                @if(isset($detail->Kelas) && isset($detail->Transaksi))
                                                    @php
                                                        $encrypt_kelas_id = Crypt::encryptString($detail->Kelas->id);
                                                        $encrypt_detail_kelas_id = Crypt::encryptString($detail->id);
                                                    @endphp
                                                    <div class="swiper-slide">
                                                        <!-- Card -->
                                                        <div class="card z-depth-1 mb-5 m-1">

                                                        <!-- Card image -->
                                                        @if(isset($detail->Kelas->logo_kelas))
                                                            <img class="card-img-top" src="{{ url('storage\image_kelas',[$detail->Kelas->logo_kelas]) }}" alt="Card image cap" style="height:200px;object-fit:cover;">
                                                        @else
                                                            <img class="card-img-top" src="{{ asset('storage\image_kelas\default.jpg') }}" alt="Card image cap" style="height:200px;object-fit:cover;">
                                                        @endif

                                                        <!-- Card content -->
                                                        <div class="card-body text-center">

                                                            <!-- Title -->
                                                            <h4 class="card-title" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">{{$detail->Kelas->nama_kelas}}</h4>
                                                            <!-- Text -->
                                                            <div class="row mt-3">

                                                                <div class="col">
                                                                    @if(isset($detail->Kelas->Pengajar->foto_pengajar))
                                                                        <img src="{{ url('storage\image_pengajar',[$detail->Kelas->Pengajar->foto_pengajar]) }}" alt="" class="img-thumbnail rounded-circle bg-secondary" style="width:50px;height:50px;object-fit:cover;">
                                                                    @else
                                                                        <img src="{{ url('storage\image_pengajar\default.jpg') }}" alt="" class="img-thumbnail rounded-circle bg-secondary" style="width:50px;height:50px;object-fit:cover;">
                                                                    @endif
                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <b style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                                                                    @if(isset($detail->Kelas->Pengajar->nama_pengajar))
                                                                        {{ $detail->Kelas->Pengajar->nama_pengajar }}
                                                                    @else
                                                                        BELUM ADA PENGAJAR
                                                                    @endif
                                                                    </b>
                                                                </div>
                                                            </div>

                                                            <div class="row p-0 m-0">
                                                                <div class="col p-0 m-0">
                                                                    <p style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                                                                    @if(isset($detail->Kelas->hsk))
                                                                        {{ strtoupper($detail->Kelas->hsk) }}
                                                                    @else
                                                                        HSK KELAS BELUM DITENTUKAN
                                                                    @endif
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    @if(isset($detail->Transaksi->status))
                                                                        @switch($detail->Transaksi->status)
                                                                            @case("menunggu_pembayaran")
                                                                                <small class="badge badge-pill badge-warning" data-toggle="tooltip" title="Kelas ini ditutup oleh admin">MENUNGGU PEMBAYARAN</small>
                                                                                @break
                                                                            @case("memilih_metode_pembayaran")
                                                                                <small class="badge badge-pill badge-warning" data-toggle="tooltip" title="Kelas ini ditutup oleh admin">KONFIRMASI PEMBAYARAN </small>
                                                                                @break
                                                                            @case("menunggu_konfirmasi")
                                                                                <small class="badge badge-pill badge-warning" data-toggle="tooltip" title="Kelas ini ditutup oleh admin">MENUNGGU KONFIRMASI</small>
                                                                                @break
                                                                            @case("lunas")
                                                                                <small class="badge badge-pill badge-success" data-toggle="tooltip" title="Kelas ini ditutup oleh admin">SELESAI</small>
                                                                                @break
                                                                            @case("dibatalkan_user")
                                                                                <small class="badge badge-pill badge-danger" data-toggle="tooltip" title="Kelas ini ditutup oleh admin">DIBATALKAN USER</small>
                                                                                @break
                                                                            @case("ditolak_admin")
                                                                                <small class="badge badge-pill badge-danger" data-toggle="tooltip" title="Kelas ini ditutup oleh admin">DITOLAK ADMIN</small>
                                                                                @break
                                                                            @case("expired_system")
                                                                                <small class="badge badge-pill badge-danger" data-toggle="tooltip" title="Kelas ini ditutup oleh admin">EXPIRED</small>
                                                                                @break
                                                                        @endswitch
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="row p-2">
                                                                <div class="col-lg-12 col-xl-6">
                                                                    <a href="{{ Route('user.kelas.beranda',[$encrypt_detail_kelas_id]) }}" class="btn btn-outline-secondary">MASUK</a>
                                                                </div>
                                                                <div class="col-lg-12 col-xl-6">
                                                                    <a href="{{ Route('user.jadwal.kelas',[$encrypt_kelas_id]) }}" class="btn btn-success">JADWAL</a>
                                                                </div>
                                                            </div>
                                                            <!-- Button -->

                                                        </div>

                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <div class="text-center w-100 mt-5 mb-5 d-flex justify-content-center align-items-center">
                                                <div>
                                                    <img src="{{ asset('asset\image\main_asset\nodata2.png') }}" alt="NO DATA" style="display:block;margin:auto;width:200px;">
                                                </div>

                                                <div>
                                                    <h5>TIDAK ADA DATA</h5>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                            <div class="text-center w-100 mt-5 mb-5 d-flex justify-content-center align-items-center">
                                                <div>
                                                    <img src="{{ asset('asset\image\main_asset\nodata2.png') }}" alt="NO DATA" style="display:block;margin:auto;width:200px;">
                                                </div>

                                                <div>
                                                    <h5>TIDAK ADA DATA</h5>
                                                </div>
                                            </div>
                                    @endif
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- END COINTAINER -->
@endsection

@push('js')
<script type="text/javascript" src="{{ asset('plugins\swiper\swiper-bundle.min.js') }}"></script>
<script>
      var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 10,
        freeMode: false,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        breakpoints: {
          640: {
            slidesPerView: 2,
            spaceBetween: 10,
          },
          768: {
            slidesPerView: 2,
            spaceBetween: 20,
          },
          1024: {
            slidesPerView: 2,
            spaceBetween: 30,
          },
        },
      });
    </script>
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