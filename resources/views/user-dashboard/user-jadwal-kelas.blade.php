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
                        <li class="breadcrumb-item"><a href="{{ route('user.pendaftaran') }}" class="text-secondary font-weight-bold">Pendaftaran</a></li>
                        <li class="breadcrumb-item"><a href="{{ url()->current() }}" class="text-dark">@if(isset($kelas))Jadwal {{ $kelas->nama_kelas }}@endif</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row d-flex justify-content-center">

            <div class="col-md-12 col-sm-12 col-lg-4 m-1 p-0 animated slideInLeft">
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

                            <div class="col-12 d-flex justify-content-center align-items-start text-left">

                                <div>
                                    @php $foto_pengajar = isset($kelas->Pengajar->foto_pengajar) ? $kelas->Pengajar->foto_pengajar : 'default.jpg' @endphp
                                    <img src="{{ url('storage\image_pengajar',[$foto_pengajar]) }}" alt="" class="rounded bg-secondary" style="width:80px;height:70px;object-fit:cover;display:block;margin:auto;">
                                </div>

                                <div class="ml-1">
                                    <small  style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width:200px;" class="font-weight-bold">
                                        @if(isset($kelas->Pengajar->nama_pengajar))
                                            {{ $kelas->Pengajar->nama_pengajar }}
                                        @else
                                            Pengajar belum ditentukan
                                        @endif
                                    </small>
                                    <div style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><small>{{ 'Pengajar '.strtoupper($kelas->hsk) }}</small></div>
                                    <div style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" class="text-secondary"><small class="font-weight-bold">{{ 'Rp.'. number_format($kelas->harga) }}</small></div>
                                </div>

                            </div>

                        </div>

                        <div class="row mt-4">
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

                        <div class="row">
                            <div class="col-sm-12 text-right">
                                {{$kelas->DetailKelas->count().'/'.$kelas->kuota}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 p-2 m-0">
                                <div class="progress border border-secondary">
                                    <div class="progress-bar bg-secondary" role="progressbar" style="width:@if($kelas->kuota != 0){{ ($kelas->DetailKelas->count()/$kelas->kuota*100).'%' }};@endif"
                                    >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-6 p-2">
                                <a href="{{ route('user.pendaftaran') }}" class="btn btn-block btn-outline-danger waves-effect @if($kelas->isLocked) disabled @endif">Back</a>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6 p-2">
                                <a href="#" class="btn btn-success btn-block text-nowrap  @if($kelas->isLocked) disabled @endif">Ikuti</a>
                            </div>
                        </div>
                        <!-- Button -->

                    </div>

                </div>
            </div>

            <div class="col-md-12 col-sm-12 col-lg-7 m-1 p-3 jumbotron animated slideInRight">
                <h5 class="font-weight-bold">{{ strtoupper($kelas->nama_kelas) }}</h5>
                <table class="mt-3">
                    <tr>
                        <th class="pr-2">
                            Tanggal Mulai 
                        </th>
                        <td>
                            : {{ Carbon\Carbon::create($kelas->tanggal_mulai)->translatedFormat('l, Y-m-d')}}
                        </td>
                    </tr>
                    <tr>
                        <th class="pr-2">
                            Tanggal Selesai
                        </th>
                        <td>
                            : {{ Carbon\Carbon::create($kelas->tanggal_selesai)->translatedFormat('l, Y-m-d')}}
                        </td>
                    </tr>
                </table>
                <div class="table-responsive-sm">
                    <table class="table table-striped mt-3 text-nowrap">
                        <thead class="bg-primary text-white">
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
                                    <td>{{ $index+1 }}</td>
                                    <td>{{$period_jadwal['period']->translatedFormat('l, Y-m-d')}}</td>
                                    <td>{{$period_jadwal['jadwal']->waktu_mulai.' '.strtoupper($period_jadwal['jadwal']->zona_waktu)}}</td>
                                    <td>{{$period_jadwal['jadwal']->waktu_selesai.' '.strtoupper($period_jadwal['jadwal']->zona_waktu)}}</td>
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