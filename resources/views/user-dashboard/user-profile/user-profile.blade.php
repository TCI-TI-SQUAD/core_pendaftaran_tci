@extends('layout.main-layout.main-layout')

@push('css')
<link href="{{ asset('asset\css\user\user-profile.css') }}" rel="stylesheet">
@endpush

@section('navigation-wide')
    @include('user-dashboard.user-nav.top-nav-wide',['profile' => 'active'])
@endsection

@section('navigation-small')
    @include('user-dashboard.user-nav.top-nav-small',['profile' => 'active'])
@endsection

@section('content')
    <!-- CONTAINER -->
    <div class="container-fluid">
        <div class="row z-depth-3" style="height:45vh; overflow:hidden;">
            <div class="col-12 p-0 m-0">
                <img src="{{ asset('asset\image\main_asset\profile-decoration.jpg') }}" id="image_background" alt="">
            </div>
        </div>
        <div class="container position-relative" style="top:-130px;">
            <div class="row">
                <div class="col-12 col-lg-8 m-auto p-0">
                    <div class="jumbotron border-secondary mt-3 animated slideInUp" style="border-top:10px solid;">
                        <div class="container">
                            <a href="{{ route('user.profile.edit') }}" class="btn btn-sm btn-outline-secondary rounded position-absolute d-lg-block d-none" style="font-size:20px;right:10px;top:10px;z-index:1;"><i class="fas fa-edit"></i> EDIT</a>
                            <div class="row position-relative">
                                @if(isset($user))
                                    <div class="col-12 text-center position-absolute animated slideInDown" id="image_profile">
                                        <a href="{{ asset('storage\image_users').'/'.$user->user_profile_pict }}" target="__blank">
                                            <img class="img-thumbnail z-depth-2 rounded-circle" src="{{ asset('storage\image_users').'/'.$user->user_profile_pict }}" alt="" style="object-fit:cover;width:170px;height:170px;">
                                        </a>
                                    </div>
                                    <div class="col-12 mt-5">
                                        <h5 class="text-center mt-3">{{ $user->name }}</h5>
                                        <p class="text-center m-0"><small >Alsan</small></p>
                                        <p class="text-center m-4">
                                            @if($user->hsk == 'pemula')
                                                <span class="blue-grey lighten-3 p-2 rounded font-weight-bold">PEMULA</span>
                                            @elseif($user->hsk == 'hsk 1')
                                                <span class="yellow lighten-1 p-2 rounded font-weight-bold">HSK 1</span>  
                                            @elseif($user->hsk == 'hsk 2')
                                                <span class="yellow darken-5 darken-2 p-2 rounded font-weight-bold">HSK 2</span>  
                                            @elseif($user->hsk == 'hsk 3')
                                                <span class="yellow darken-4 darken-2 p-2 rounded font-weight-bold">HSK 3</span>
                                            @elseif($user->hsk == 'hsk 4')
                                                <span class="aqua-gradient p-2 rounded font-weight-bold">HSK 4</span>  
                                            @elseif($user->hsk == 'hsk 5')
                                                <span class="blue-gradient p-2 rounded font-weight-bold">HSK 5</span>  
                                            @elseif($user->hsk == 'hsk 6')
                                                <span class="peach-gradient p-2 rounded font-weight-bold">HSK 6</span>  
                                            @else
                                                <span class="peach-gradient p-2 rounded font-weight-bold">PEMULA</span>  
                                            @endif
                                        </p>
                                        
                                        <label ><i class="fas fa-id-card-alt"></i> Nomor Pelajar TCI</label>
                                        <input type="text" class="form-control" value="{{ $user->nomor_pelajar_tci }}" readonly>
                                        <label ><i class="fas fa-laptop-house"></i>Instansi</label>
                                        <input type="text" class="form-control" value="{{ $user->getInstansiName() }}" readonly>
                                        <label class="mt-2"><i class="fas fa-envelope-square"></i> E-mail</label>
                                        <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                                        <label class="mt-2"><i class="fas fa-phone-square-alt"></i> Phone Number</label>
                                        <input type="text" class="form-control" value="{{ $user->phone_number }}" readonly>
                                        <label class="mt-2"><i class="fab fa-line"></i> Line</label>
                                        <input type="text" class="form-control" value="{{ $user->line }}" readonly>
                                        <label class="mt-2"> <i class="fab fa-whatsapp-square"></i> WA</label>
                                        <input type="text" class="form-control" value="{{ $user->wa }}" readonly>
                                        <label class="mt-2"><i class="fab fa-line"></i> Kartu Identitas</label>
                                        <div class="text-center">
                                        <a href="{{ asset('storage/kartu_identitas').'/'.$user->kartu_identitas }}" target="__blank" class="btn btn-sm m-auto w-50 d-none d-lg-block btn-block btn-primary"><i class="far fa-eye"></i> LIHAT KARTU IDENTITAS</a>
                                        <a href="{{ asset('storage/kartu_identitas').'/'.$user->kartu_identitas }}" target="__blank" class="btn btn-sm m-auto w-100 d-block d-lg-none btn-block btn-primary"><i class="far fa-eye"></i> LIHAT KARTU IDENTITAS</a>
                                        <a href="{{ route('user.profile.edit') }}" class="btn btn-sm my-4 mx-auto d-block btn-outline-secondary rounded d-lg-none"><i class="fas fa-edit"></i> EDIT PROFILE</a>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-12 text-center">
                                        TIDAK ADA PROFILE
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