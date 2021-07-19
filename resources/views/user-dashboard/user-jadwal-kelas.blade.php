@extends('layout.main-layout.main-layout')

@push('css')
<link href="{{ asset('asset\css\user\user-jadwal-kelas.css') }}" rel="stylesheet">
@endpush

@section('navigation-wide')
    @include('user-dashboard.user-nav.top-nav-wide',['pendaftaran' => 'active'])
@endsection

@section('navigation-small')
    @include('user-dashboard.user-nav.top-nav-small')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-white m-3">
                        <li class="breadcrumb-item"><a href="{{ route('user.pendaftaran') }}">Pendaftaran</a></li>
                        <li class="breadcrumb-item"><a href="{{ url()->current() }}" class="text-dark">@if(isset($kelas))Jadwal {{ $kelas->nama_kelas }}@endif</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-5 col-sm-12 col-lg-4 mb-3 animated slideInLeft">
                <!-- Card -->
                <div class="card" @if($kelas->isLocked)style="opacity:0.6;"@endif>

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
                            <div class="col-sm-6">
                                Kuota : {{$kelas->DetailKelas->count().'/'.$kelas->kuota}}
                            </div>
                        </div>

                        <div class="progress ml-1 mr-1 mb-1 border border-secondary">
                            <div class="progress-bar bg-secondary" role="progressbar" style="width:@if($kelas->kuota != 0){{ ($kelas->DetailKelas->count()/$kelas->kuota*100).'%' }};@endif"
                            >
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <a href="{{ route('user.jadwal.kelas',['id_kelas' => $kelas->id]) }}" class="btn btn-outline-secondary waves-effect @if($kelas->isLocked) disabled @endif">Jadwal</a>
                            </div>
                            <div class="col-sm-6">
                                <a href="#" class="btn btn-success  @if($kelas->isLocked) disabled @endif">Ikuti</a>
                            </div>
                        </div>
                        <!-- Button -->

                    </div>

                </div>
            </div>

            <div class="col-md-7 col-sm-12 col-lg-8 jumbotron p-3 mb-3 animated slideInRight">
                <h5 class="font-weight-bold">{{ strtoupper($kelas->nama_kelas) }}</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nomor</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Waktu Mulai</th>
                                <th scope="col">Waktu Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($real_period as $index => $period_jadwal)
                                <tr>
                                    <td>{{ $index }}</td>
                                    <td>{{$period_jadwal['period']->format('l, Y-m-d H:i:s')}}</td>
                                    <td>{{$period_jadwal['jadwal']->waktu_mulai.' '.strtoupper($period_jadwal['jadwal']->zona_waktu)}}</td>
                                    <td>{{$period_jadwal['jadwal']->waktu_mulai.' '.strtoupper($period_jadwal['jadwal']->zona_waktu)}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
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