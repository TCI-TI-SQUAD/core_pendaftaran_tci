@extends('layout.main-layout.main-layout')

@push('css')
<link href="{{ asset('asset\css\user\user-pembayaran.css') }}" rel="stylesheet">
@endpush

@section('navigation-wide')
    @include('user-dashboard.user-nav.top-nav-wide',['kelas_saya' => 'active'])
@endsection

@section('navigation-small')
    @include('user-dashboard.user-nav.top-nav-small',['kelas_saya' => 'active'])
@endsection

@section('content')
    @if(isset($detail_kelas->id))
        @php $encrypt_detail_kelas_id = Crypt::encryptString($detail_kelas->id)@endphp
    @endif
    <!-- CONTAINER -->
    <div class="container">
        <div class="row d-flex justify-content-center">
            
            <div class="col-12 mt-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-white">
                        <li class="breadcrumb-item"><a href="#" class="text-secondary font-weight-bold">Kelas Saya</a></li>
                        <li class="breadcrumb-item"><a href="#" class="text-secondary font-weight-bold">
                            @if(isset($detail_kelas->Kelas->nama_kelas)){{ $detail_kelas->Kelas->nama_kelas }}@endif
                        </a></li>
                        <li class="breadcrumb-item active"><a href="" class="text-secondary font-weight-bold">Pembayaran</a></li>
                        <li class="breadcrumb-item active">Konfirmasi</li>
                    </ol>
                </nav>
            </div>

            <div class="col-12 m-0">
                <!-- Horizontal Steppers -->
                <div class="row m-0 justify-content-center align-items-center">
                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-xs-6 d-flex justify-content-center order-xl-1 order-lg-1">
                        <a href="{{ route('user.pembayaran.kelas',[$encrypt_detail_kelas_id]) }}" class="btn btn-sm btn-outline-secondary">BACK</a>
                    </div>
                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-xs-6 d-flex justify-content-center order-xl-3 order-lg-2">
                        <a href="{{ route('user.upload.kelas',[$encrypt_detail_kelas_id]) }}" class="btn btn-sm btn-secondary">NEXT</a>
                    </div>
                    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-xs-12 order-xl-2  order-lg-3">

                        <!-- Stepers Wrapper -->
                        <ul class="stepper stepper-horizontal">
                            <!-- First Step -->
                            <li class="step">
                                <a href="#!">
                                <span class="circle bg-secondary f">1</span><small>KONFIRMASI</small>
                                </a>
                            </li>

                            <!-- Second Step -->
                            <li class="step">
                                <a href="#!">
                                <span class="circle">2</span><small>UPLOAD</small>
                                </a>
                            </li>
                            <!-- Third Step -->
                            <li class="step-actions">
                                <a href="#!">
                                <span class="circle">3</span><small>VERIFIKASI</small>
                                </a>
                            </li>

                            <!-- Third Step -->
                            <li class="step-actions">
                                <a href="#!">
                                <span class="circle">4</span><small>SELESAI</small>
                                </a>
                            </li>
                        </ul>
                        <!-- /.Stepers Wrapper -->

                    </div>
                </div>
                <!-- /.Horizontal Steppers -->
            </div>
        </div>

        @if(isset($detail_kelas->Transaksi))
                <div class="row d-flex justify-content-center p-2">
                    <div class="col-xl-8 col-md-8 col-12 jumbotron p-0 z-depth-1 d-flex flex-column justify-content-center align-items-center">
                        <div class="bg-secondary w-100" style="height:10px;"></div>
                        <div class="mt-3">
                            <h5 class="font-weight-bold text-secondary text-center">KONFIRMASI PEMESANAN DAN PEMBAYARAN</h5>
                        </div>
                        <div class="">
                            <p class="text-center">Bayar Sebelum <span class="text-secondary font-weight-bold">
                                @if(isset($detail_kelas->Transaksi->tanggal_expired))
                                    {{ Carbon\Carbon::create($detail_kelas->Transaksi->tanggal_expired)->translatedFormat('l , Y-M-d H:i:s').' WITA' }}
                                @endif
                            </span></p>
                        </div>
                        <div class="">
                            <h4 class="text-secondary font-weight-bold text-uppercase text-center">@if(isset($detail_kelas->Kelas->nama_kelas)){{ $detail_kelas->Kelas->nama_kelas }} @else Unknown Class @endif</h4>
                        </div>
                        <div class="">
                            <h5 class="text-center"><span class="text-secondary font-weight-bold">IDR @if(isset($detail_kelas->Kelas->harga)){{ number_format($detail_kelas->Kelas->harga) }} @else Unknown Class @endif</span></h5>
                        </div>
                        <div class="">
                            <h5 class="text-center">Transfer pembayaran ke rekening atas nama</h5>
                        </div>
                        <div class="">
                            <h5 class="text-center">Admin Sistem TCI</h5>
                        </div>
                        <div class="d-flex justify-content-center align-items-center mb-3 mt-3">
                            <img src="{{ asset('storage\image_metode_pembayaran\bca.png') }}" alt="BANK BCA" style="display:block;marginL:auto;width:80px;">
                            123123213
                        </div>
                        
                        <div class="d-flex justify-content-center align-items-center mt-3">
                            <button class="btn btn-sm btn-outline-secondary" style="width:200px;">PANDUAN PEMBAYARAN</button>
                        </div>

                        <div class="d-flex justify-content-center align-items-center">
                            <a href="{{ route('user.upload.kelas',[$encrypt_detail_kelas_id]) }}" class="btn btn-sm btn-secondary" style="width:200px;" form="form-upload-bukti">UPLOAD BUKTI</a>
                        </div>
                        
                        @if($detail_kelas->Transaksi->status != 'lunas')
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <a href="{{ route('user.upload.kelas',[$encrypt_detail_kelas_id]) }}" class="btn btn-sm btn-danger" style="width:200px;" form="form-upload-bukti">BATALKAN PEMESANAN</a>
                            </div>
                        @endif
                    </div>
                </div>
        @endif

    </div>
    <!-- END COINTAINER -->
@endsection

@push('js')
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