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
        <div class="row bg-danger" style="height:45vh; overflow:hidden;">
            <div class="col-12 p-0 m-0">
                <img src="{{ asset('asset\image\main_asset\profile-decoration.jpg') }}" id="image_background" alt="">
            </div>
        </div>
        <div class="container position-relative" style="top:-130px;">
            <div class="row">
                <div class="col-12 col-lg-8 mx-auto jumbotron p-0 animated slideInUp">
                    <div class="row m-0 p-0">
                        <div class="col-12 text-center p-2 text-white" style="background: rgb(89,15,16);background: linear-gradient(90deg, rgba(89,15,16,1) 0%, rgba(207,29,32,1) 100%);">
                            FORM EDIT PROFILE ANGGOTA
                        </div>
                    </div>
                    <form action="{{ route('user.profile.store') }}" id="form-edit" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 col-lg-4 mx-auto m-lg-0 text-center p-4">
                                <div class="col-12">
                                    <a href="{{ asset('storage\image_users').'/'.$user->user_profile_pict }}" target="__blank">
                                        <img class="img-thumbnail z-depth-2 rounded-circle" src="{{ asset('storage\image_users').'/'.$user->user_profile_pict }}" alt="" style="object-fit:cover;width:120px;height:120px;" id="img">
                                    </a>
                                </div>
                                <div class="col-12 mt-3">
                                    <input name="image_user" type="file" class="d-none" form="form-edit" id="input_image_user" onchange="readURL(this)">
                                    <label for="input_image_user" href="" class="btn btn-sm btn-outline-secondary">GANTI FOTO</label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-8 p-4">
                                    <label class="mt-2"><i class="fas  fa-id-card-alt"></i> Nama Lengkap</label>
                                    <input name="name" type="text" class="form-control" value="{{ $user->name }}">

                                    <label class="mt-2"><i class="fas  fa-id-card-alt"></i> Username</label>
                                    <input name="username" type="text" class="form-control" value="{{ $user->username }}">

                                    <label class="mt-2"><i class="fas fa-medal"></i> Level HSK</label>
                                    <select name="hsk" class="browser-default custom-select">
                                        <option value="1">PEMULA</option>
                                        <option value="2">HSK 1</option>
                                        <option value="3">HSK 2</option>
                                    </select>

                                    <label class="mt-2"><i class="fas  fa-id-card-alt"></i> Nomor Pelajar TCI</label>
                                    <input type="text" class="form-control" value="{{ $user->nomor_pelajar_tci }}" readonly>
                                    <label class="mt-2"><i class="fas  fa-laptop-house"></i> Instansi</label>
                                    <input type="text" class="form-control" value="{{ $user->getInstansiName() }}" readonly>

                                    <label class="mt-2"><i class="fas  fa-envelope-square"></i> E-mail</label>
                                    <input name="email" type="text" class="form-control" value="{{ $user->email }}">

                                    <label class="mt-2"><i class="fas  fa-phone-square-alt"></i> Phone Number</label>
                                    <input name="phone_number" type="text" class="form-control" value="{{ $user->phone_number }}">

                                    <label class="mt-2"><i class="fab fa-line"></i> Line</label>
                                    <input name="line" type="text" class="form-control" value="{{ $user->line }}">

                                    <label class="mt-2"> <i class="fab fa-whatsapp-square"></i> WA</label>
                                    <input name="wa" type="text" class="form-control" value="{{ $user->wa }}">

                                    <label class="mt-2"><i class="fab fa-line"></i> Kartu Identitas</label><br>
                                    <a href="{{ asset('storage/kartu_identitas').'/'.$user->kartu_identitas }}" class="btn-sm btn-info my-2">Lihat Kartu Identitas Saat ini</a>
                                    <div class="input-group mt-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupFileAddon01">Upload Kartu Baru</span>
                                        </div>
                                        <div class="custom-file">
                                            <input name="kartu_identitas" type="file" class="custom-file-input" id="inputGroupFile01"
                                            aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 px-4 px-lg-5 py-2">
                                <button type="submit" class="btn btn-block btn-outline-secondary">SIMPAN</button>
                            </div>
                            <div class="col-12 px-4 px-lg-5 py-2 mb-3">
                                <a href="{{ route('user.profile.index') }}" class="btn btn-block btn-danger">BACK</a>
                            </div>
                        </div>
                    </form>
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
    function readURL(input){
            var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();

            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#img').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }else{
                $('#img').attr('src', '/assets/no_preview.png');
            }
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