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
    @if(isset($detail_kelas))
        @php 
            $encrypt_kelas_id = Crypt::encryptString($detail_kelas->Kelas->id);
            $encrypt_detail_kelas_id = Crypt::encryptString($detail_kelas->id);
        @endphp
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
                        <li class="breadcrumb-item active">Upload</li>
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
                        <a href="{{ route('user.verifikasi.kelas',[$encrypt_detail_kelas_id]) }}" class="btn btn-sm btn-secondary">NEXT</a>
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
                            <h5 class="font-weight-bold text-secondary text-center">UPLOAD BUKTI PEMBAYARAN</h5>
                        </div>

                        <div class="d-flex justify-content-center align-items-center m-3" data-toggle="tooltip" title="File bukti transaksi dapat diubah dengan cara upload ulang file bukti yang baru">
                            @if($detail_kelas->Transaksi->file_bukti_transaksi == null)
                                <img src="{{ asset('asset\image\main_asset\upload_bukti.png') }}" id="imgpreview" alt="UPLOAD IMAGE" class="w-25">
                            @else
                                <img src="{{ url('storage\image_bukti_transaksi',[$detail_kelas->Transaksi->file_bukti_transaksi]) }}" id="imgpreview" alt="UPLOAD IMAGE" class="w-25">
                            @endif
                        </div>

                        <div class="text-center ml-3 mr-3">
                            <h5>Setelah melakukan transfer pada nomor rekening pada <span class="font-weight-bold">Step 1</span>, Silahkan unggah bukti pembayaran tersebut di sini.</h5>
                        </div>

                        <div class="input-group" style="width:200px;">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="imginput"
                                aria-describedby="inputGroupFileAddon01" name="file_bukti_pembayaran" form="form-upload-bukti" required>
                                <label class="custom-file-label" for="imginput">Choose file</label>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center align-items-center mt-3">
                            <button class="btn btn-sm btn-outline-secondary" style="width:180px;">PANDUAN PEMBAYARAN</button>
                        </div>

                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <button class="btn btn-sm btn-secondary" style="width:180px;" form="form-upload-bukti">UPLOAD & VERIFIKASI</button>
                        </div>

                        <form action="{{ route('user.upload.bukti') }}" enctype="multipart/form-data" method="POST" id="form-upload-bukti" style="display:none;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id_detail_kelas" value="{{ $encrypt_detail_kelas_id }}">
                        </form>
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
        // PREVIEW IMAGE
            $('#imginput').on('change',function(e){
                console.log(e.target.files[0]);

                const file = e.target.files[0];

                if (file) {
                    $('#imgpreview').attr('src',URL.createObjectURL(file))
                }
            })
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