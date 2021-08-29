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
                <div class="col-12 col-lg-8 mx-auto jumbotron p-0 animated slideInUp">
                    <div class="row m-0 p-0">
                        <div class="col-12 text-center p-2 text-white" style="background: rgb(89,15,16);background: linear-gradient(90deg, rgba(89,15,16,1) 0%, rgba(207,29,32,1) 100%);">
                            FORM EDIT PROFILE ANGGOTA
                        </div>
                    </div>
                    <form action="{{ route('user.profile.store') }}" id="form-edit" enctype="multipart/form-data" method="POST"  onsubmit="myButton.disabled = true; return true;">
                        @csrf
                        @method('PUT')
                        <div class="row p-0 m-0">
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
                            <div class="col-12 col-lg-8 py-4 px-4 px-lg-0 pr-lg-4">
                                    <label class="mt-2"><i class="fas  fa-id-card-alt"></i> Nama Lengkap</label>
                                    <input name="name" type="text" class="form-control @if($errors->has('name')) border border-danger @endif" value="{{ $user->name }}" minlength="3" maxlength="50">
                                    @if($errors->has('name')) <p class="text-danger m-0 p-0"><small>{{ $errors->first('name') }}</small></p> @endif

                                    <label class="mt-2"><i class="fas  fa-id-card-alt"></i> Username</label>
                                    <input name="username" type="text" class="form-control @if($errors->has('username')) border border-danger @endif" value="{{ $user->username }}" minlength="3" maxlength="15">
                                    @if($errors->has('username')) <p class="text-danger m-0 p-0"><small>{{ $errors->first('username') }}</small></p> @endif

                                    <label class="mt-2"><i class="fas fa-medal"></i> Level HSK</label>
                                    <select name="hsk" class="browser-default custom-select @if($errors->has('hsk')) border border-danger @endif">
                                        <option value="pemula" @if($user->hsk == 'pemula') selected @endif</option>PEMULA</option>
                                        <option value="hsk 1" @if($user->hsk == 'hsk 1') selected @endif>HSK 1</option>
                                        <option value="hsk 2" @if($user->hsk == 'hsk 2') selected @endif>HSK 2</option>
                                        <option value="hsk 3" @if($user->hsk == 'hsk 3') selected @endif>HSK 3</option>
                                        <option value="hsk 4" @if($user->hsk == 'hsk 4') selected @endif>HSK 4</option>
                                        <option value="hsk 5" @if($user->hsk == 'hsk 5') selected @endif>HSK 5</option>
                                        <option value="hsk 6" @if($user->hsk == 'hsk 6') selected @endif>HSK 6</option>
                                    </select>
                                    @if($errors->has('hsk')) <p class="text-danger m-0 p-0"><small>{{ $errors->first('hsk') }}</small></p> @endif

                                    <label class="mt-2"><i class="fas  fa-id-card-alt"></i> Nomor Pelajar TCI</label>
                                    <input type="text" class="form-control" value="{{ $user->nomor_pelajar_tci }}" readonly>
                                    <label class="mt-2"><i class="fas  fa-laptop-house"></i> Instansi</label>
                                    <input type="text" class="form-control" value="{{ $user->getInstansiName() }}" readonly>

                                    <label class="mt-2"><i class="fas  fa-envelope-square"></i> E-mail</label>
                                    <input name="email" type="email" class="form-control @if($errors->has('email')) border border-danger @endif" value="{{ $user->email }}" minlength="3" maxlength="50">
                                    @if($errors->has('email')) <p class="text-danger m-0 p-0"><small>{{ $errors->first('email') }}</small></p> @endif

                                    <label class="mt-2"><i class="fas  fa-phone-square-alt"></i> Phone Number</label>
                                    <input name="phone_number" type="tel" class="form-control @if($errors->has('phone_number')) border border-danger @endif" value="{{ $user->phone_number }}" pattern="(\+62)([0-9]*$)" minlength="7" maxlength="15" >
                                    @if($errors->has('phone_number')) <p class="text-danger m-0 p-0"><small>{{ $errors->first('phone_number') }}</small></p> @endif

                                    <label class="mt-2"><i class="fab fa-line"></i> Line</label>
                                    <input name="line" type="text" class="form-control @if($errors->has('line')) border border-danger @endif" value="{{ $user->line }}" minlength="3" maxlength="50">
                                    @if($errors->has('line')) <p class="text-danger m-0 p-0"><small>{{ $errors->first('line') }}</small></p> @endif

                                    <label class="mt-2"> <i class="fab fa-whatsapp-square"></i> WA</label>
                                    <input name="wa" type="tel" class="form-control @if($errors->has('wa')) border border-danger @endif" value="{{ $user->wa }}" pattern="(\+62)([0-9]*$)" minlength="7" maxlength="15">
                                    @if($errors->has('wa')) <p class="text-danger m-0 p-0"><small>{{ $errors->first('wa') }}</small></p> @endif

                                    <label class="mt-2"><i class="fas fa-map-marker-alt"></i> Alamat Lengkap</label>
                                    <input name="alamat" type="text" class="form-control @if($errors->has('alamat')) border border-danger @endif" value="{{ $user->alamat }}" minlength="5" maxlength="50">
                                    @if($errors->has('alamat')) <p class="text-danger m-0 p-0"><small>{{ $errors->first('alamat') }}</small></p> @endif

                                    <label class="mt-2"><i class="fas fa-key"></i> Password</label>
                                    <input name="password" placeholder="Isi apabila ingin mengganti password" type="password" class="form-control @if($errors->has('password')) border border-danger @endif" minlength="5" maxlength="100">
                                    @if($errors->has('password')) <p class="text-danger m-0 p-0"><small>{{ $errors->first('password') }}</small></p> @endif

                                    <label class="mt-2"><i class="fas fa-key"></i> Password Confirmation</label>
                                    <input name="password_confirmation" placeholder="Isi apabila ingin mengganti password" type="password" class="form-control @if($errors->has('password_confirmation')) border border-danger @endif"  minlength="5" maxlength="100">
                                    @if($errors->has('password_confirmation')) <p class="text-danger m-0 p-0"><small>{{ $errors->first('password_confirmation') }}</small></p> @endif

                                    <label class="mt-2"><i class="fab fa-line"></i> Kartu Identitas</label><br>
                                    <a href="{{ asset('storage/kartu_identitas').'/'.$user->kartu_identitas }}" class="btn-sm btn-info my-2">Lihat Kartu Identitas Saat ini</a>
                                    <div class="input-group mt-3 ">
                                        <div class="input-group-prepend @if($errors->has('kartu_identitas')) border border-danger @endif">
                                            <span class="input-group-text" id="inputGroupFileAddon01">Upload Kartu Baru</span>
                                        </div>
                                        <div class="custom-file">
                                            <input name="kartu_identitas" type="file" class="custom-file-input" id="inputGroupFile01"
                                            aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                    </div>
                                    @if($errors->has('kartu_identitas')) <p class="text-danger m-0 p-0"><small>{{ $errors->first('kartu_identitas') }}</small></p> @endif

                                     <!-- Group of default radios - option 1 -->
                                    <div class="custom-control custom-radio mt-2">
                                        <input type="radio" class="custom-control-input" id="defaultGroupExample1" name="jenis_kartu_identitas" value="ktp" @if($user->jenis_kartu_identitas == 'ktp') checked @endif required>
                                        <label class="custom-control-label" for="defaultGroupExample1">KTP</label>
                                    </div>

                                    <!-- Group of default radios - option 2 -->
                                    <div class="custom-control custom-radio mt-2">
                                        <input type="radio" class="custom-control-input" id="defaultGroupExample2" name="jenis_kartu_identitas" value="nisn" @if($user->jenis_kartu_identitas == 'nisn') checked @endif required>
                                        <label class="custom-control-label" for="defaultGroupExample2">NISN</label>
                                    </div>

                                    <!-- Group of default radios - option 2 -->
                                    <div class="custom-control custom-radio mt-2">
                                        <input type="radio" class="custom-control-input" id="defaultGroupExample3" name="jenis_kartu_identitas" value="ktm" @if($user->jenis_kartu_identitas == 'ktm') checked @endif required>
                                        <label class="custom-control-label" for="defaultGroupExample3">KTM (Kartu Tanda Mahasiswa)</label>
                                    </div>

                                    <!-- Group of default radios - option 3 -->
                                    <div class="custom-control custom-radio mt-2">
                                        <input type="radio" class="custom-control-input" id="defaultGroupExample4" name="jenis_kartu_identitas" value="passport" @if($user->jenis_kartu_identitas == 'passport') checked @endif required>
                                        <label class="custom-control-label" for="defaultGroupExample4">PASSPORT</label>
                                    </div>
                                    @if($errors->has('jenis_kartu_identitas')) <p class="text-danger m-0 p-0"><small>{{ $errors->first('jenis_kartu_identitas') }}</small></p> @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 px-4 px-lg-5 py-2">
                                <button type="button" onclick="submitProfile()" class="btn btn-block btn-outline-secondary" id="myButton">SIMPAN</button>
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

        function submitProfile(){

            Swal.fire({
            title: 'Konfirmasi Perubahan ?',
            html: 'Dengan menekan tombol Simpan,maka saya <span class="text-secondary font-weight-bold">{{ $user->name }}</span> menyatakan bahwa data dan informasi yang diinputkan pada form bersifat <span class="text-secondary font-weight-bold">BENAR</span> dan <span class="text-secondary font-weight-bold">FAKTA</span>',
            icon:'warning',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Simpan`,
            denyButtonText: `Batal`,
            }).then((result) => {
                
            if (result.isConfirmed) {
                $('#form-edit').submit();
            } else if (result.isDenied) {

            }
            })

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