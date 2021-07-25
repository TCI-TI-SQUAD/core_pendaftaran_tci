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
    @if(isset($kelas))
        @php $encrypt_kelas_id = Crypt::encryptString($kelas->id)@endphp
    @endif
    <!-- CONTAINER -->
    <div class="container">
        <div class="row d-flex justify-content-center">
            
            <div class="col-12 mt-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-white">
                        <li class="breadcrumb-item"><a href="#" class="text-secondary font-weight-bold">Kelas Saya</a></li>
                        <li class="breadcrumb-item"><a href="#" class="text-secondary font-weight-bold">
                            @if(isset($kelas)){{ $kelas->nama_kelas }}@endif
                        </a></li>
                        <li class="breadcrumb-item active"><a href="" class="text-secondary font-weight-bold">Pembayaran</a></li>
                        <li class="breadcrumb-item active">Verifikasi</li>
                    </ol>
                </nav>
            </div>

            <div class="col-12 m-0">
                <!-- Horizontal Steppers -->
                <div class="row m-0 justify-content-center align-items-center">
                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-xs-6 d-flex justify-content-center order-xl-1 order-lg-1">
                        <a href="{{ route('user.upload.kelas',[$encrypt_kelas_id]) }}" class="btn btn-sm btn-outline-secondary">BACK</a>
                    </div>
                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-xs-6 d-flex justify-content-center order-xl-3 order-lg-2">
                        <a href="{{ route('user.upload.kelas',[$encrypt_kelas_id]) }}" class="btn btn-sm btn-secondary">NEXT</a>
                    </div>
                    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-xs-12 order-xl-2  order-lg-3">

                        <!-- Stepers Wrapper -->
                        <ul class="stepper stepper-horizontal">
                            <!-- First Step -->
                            <li class="step">
                                <a href="#!">
                                <span class="circle bg-secondary">1</span><small>KONFIRMASI</small>
                                </a>
                            </li>

                            <!-- Second Step -->
                            <li class="step">
                                <a href="#!">
                                <span class="circle bg-secondary">2</span><small>UPLOAD</small>
                                </a>
                            </li>
                            <!-- Third Step -->
                            <li class="step-actions">
                                <a href="#!">
                                <span class="circle bg-secondary">3</span><small>VERIFIKASI</small>
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

        @if(isset($kelas->DetailKelas[0]->Transaksi))
                <div class="row d-flex justify-content-center p-2">
                    <div class="col-xl-8 col-md-8 col-12 jumbotron p-0 z-depth-1 d-flex flex-column justify-content-center align-items-center">
                        <div class="bg-secondary w-100" style="height:10px;"></div>
                        <div class="mt-3">
                            <h5 class="font-weight-bold text-secondary text-center">MENUNGGU KONFIRMASI ADMIN</h5>
                        </div>
                        <div class="mt-2">
                            <img src="{{ url('storage/image_bukti_transaksi',[$kelas->DetailKelas[0]->Transaksi->file_bukti_transaksi]) }}" alt="" style="width:200px;max-height:300px;">
                        </div>
                        <div class="pl-5 pr-5 text-center">
                            <h4>Berhasil menggunggah bukti pembayaran ! Mohon tunggu konfirmasi dari admin</h4>
                        </div>
                        <div class="mt-2">
                            <p>Anda dapat mengganti image pembayaran kembali pada <span class="font-weight-bold">step 2</span></p>
                        </div>
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

            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
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