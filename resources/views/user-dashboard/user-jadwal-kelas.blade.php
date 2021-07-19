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
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-white m-3">
                        <li class="breadcrumb-item"><a href="{{ route('user.pendaftaran') }}">Pendaftaran</a></li>
                        <li class="breadcrumb-item"><a href="{{ url()->current() }}">@if(isset($kelas))Jadwal {{ $kelas->nama_kelas }}@endif</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row d-flex justify-content-center pl-3 pr-3">
            <div class="col-sm">
                <div class="row justify-content-baseline">
                    @if(isset($kelas->JadwalKelas) && isset($days))
                        @if($kelas->JadwalKelas->count() > 0)
                            @foreach($days as $index => $day)
                                    <div class="col-md-3 card text-center m-2 p-0" style="overflow:hidden;">
                                        <h4 class="card-title p-2 text-white" style="background: rgb(89,15,16);background: linear-gradient(90deg, rgba(89,15,16,1) 0%, rgba(207,29,32,1) 100%);">{{ strtoupper($day) }}</h4>
                                        <!-- Card content -->
                                        <div class="card-body">
                                            <!-- Title -->
                                            <!-- Text -->
                                            @if(!$kelas->JadwalKelas->where('hari',$day)->isEmpty())
                                                
                                                @php $jadwal=$kelas->JadwalKelas->where('hari',$day)->first(); @endphp

                                                <h5 class="bg-success p-3 font-weight-bold text-white rounded">ADA KELAS</h5>
                                                <p class="mt-3 font-weight-bold">{{ $jadwal->waktu_mulai.' - '.$jadwal->waktu_selesai.' '.strtoupper($jadwal->zona_waktu) }}</h1>

                                            @else

                                                <h5 class="p-3 font-weight-bold text-white rounded text-dark">TIDAK ADA KELAS</h5>
                                                <p class="card-text font-weight-bold text-dark"></p>

                                            @endif
                                        </div>
                                    </div>
                            @endforeach
                        @endif
                    @endif
                </div>
                
            </div>

            <div class="col-sm-5 jumbotron bg-danger">
                
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