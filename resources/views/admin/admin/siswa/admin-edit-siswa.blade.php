@extends('admin.admin-layout.admin-layout')

@section('siswa','active')

@section('page-name-header','Edit Siswa')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item"> <a href="{{ route('admin.siswa') }}">Siswa</a></li>
<li class="breadcrumb-item active">Edit Siswa</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 jumbotron shadow">
        <div class="container">
            <div class="row">
                @if(isset($user))
                    <div class="col-12 col-lg-3 text-center">
                        <div class="col-12 position-sticky">
                        @if(isset($user->user_profile_pict))
                            <img id="img" src="{{ asset('storage/image_users').'/'.$user->user_profile_pict }}" alt="" style="width:200px;height:200px;object-fit:cover;" class="img-thumbnail rounded-circle position-sticky">
                        @else
                            <img id="img" src="{{ asset('storage/image_users/default.jpg') }}" alt="" style="width:200px;height:200px;object-fit:cover;" class="img-thumbnail rounded-circle">
                        @endif
                        </div>
                        
                        <div class="col-12">
                            <label for="image_users" class="btn btn-sm btn-primary">GANTI GAMBAR</label>
                            @error('image_users') <p><small>{{ $errors->first('user_images') }}</small></p>@enderror
                        </div>
                    </div>
                    
                    <div class="col-12 col-lg-9">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <form action="{{ route('admin.store.siswa') }}" method="POST" enctype="multipart/form-data" id="edit-user">
                                        @csrf
                                        @method('PUT')
                                        
                                        <input name="user_profile_pict" type="file" accept="image/*" id="image_users" style="display:none;" onchange="readURL(this)">
                                        <input type="hidden" value="{{ $user->id }}" name="id">

                                        <label >Name</label>
                                        <input name="name" type="text" class="form-control @error('name') border border-danger @enderror" value="{{ $user->name }}">
                                        @error('name') <p class="p-0 m-0 text-danger"><small>{{ $errors->first('name') }}</small></p> @enderror

                                        <label class="mt-2">Username</label>
                                        <input name="username" type="text" class="form-control @error('username') border border-danger @enderror" value="{{ $user->username }}">
                                        @error('username') <p class="p-0 m-0 text-danger"><small>{{ $errors->first('username') }}</small></p> @enderror

                                        <label class="mt-2">HSK</label>
                                        <select name="hsk" class="browser-default custom-select">
                                            <option>Pilih HSK Siswa</option>
                                            <option value="pemula" @if($user->hsk == 'pemula') selected @endif>PEMULA</option>
                                            <option value="hsk 1" @if($user->hsk == 'hsk 1') selected @endif>HSK 1</option>
                                            <option value="hsk 2" @if($user->hsk == 'hsk 2') selected @endif>HSK 2</option>
                                            <option value="hsk 3" @if($user->hsk == 'hsk 3') selected @endif>HSK 3</option>
                                            <option value="hsk 4" @if($user->hsk == 'hsk 4') selected @endif>HSK 4</option>
                                            <option value="hsk 5" @if($user->hsk == 'hsk 5') selected @endif>HSK 5</option>
                                            <option value="hsk 6" @if($user->hsk == 'hsk 6') selected @endif>HSK 6</option>
                                        </select>
                                        @error('hsk') <p class="p-0 m-0 text-danger"><small>{{ $errors->first('hsk') }}</small></p> @enderror

                                        <label class="mt-2">Nomor Pelajar TCi</label>
                                        <input name="nomor_pelajar_tci" type="text" class="form-control @error('nomor_pelajar_tci') border border-danger @enderror" value="{{ $user->nomor_pelajar_tci }}">
                                        @error('nomor_pelajar_tci') <p class="p-0 m-0 text-danger"><small>{{ $errors->first('nomor_pelajar_tci') }}</small></p> @enderror

                                        <label class="mt-2">Status Instansi Saat ini</label>
                                        <input type="text" class="form-control" value="{{ $user->getInstansiName() }}" readonly>

                                        <label class="mt-2">Ganti Instansi</label>
                                        <select name="status" onchange="hideInputSystem(this.value)" type="text" placeholder="Pilih status" class="browser-default custom-select @error('status') border border-danger @enderror" required>
                                            <option value="">Pilih Instansi Baru (Kosongkan apabila tidak ingin mengganti)</option>
                                            <option value="umum" @if(old("status") == "umum") selected @endif>Umum</option>
                                            <option value="siswa" @if(old("status") == "siswa") selected @endif>Siswa</option>
                                            <option value="mahasiswa" @if(old("status") == "mahasiswa") selected @endif>Mahasiswa</option>
                                            <option value="instansi" @if(old("status") == "instansi") selected @endif>Instansi Kerjasama</option>
                                        </select>
                                        <p class="text-danger animated slideInUp"><small>{{ $errors->first('status') }}</small></p>
                                        
                                        <div id="instansi_wrapper" style="display:none;">
                                                <label for="exampleForm2" class="mt-2" data-toggle="tooltip" title="Instansi asal pendaftar apabila tidak berasal dari instansi yang ada silahkan pilih opsi UMUM">Instansi <span class="text-danger"> * </span><i class="fas fa-question-circle"></i></label>
                                                
                                                @if($errors->has('instansi'))
                                                    <select name="instansi" id="#instansi_input" onchange="" type="text" placeholder="Pilih instansi" class="browser-default custom-select border border-danger" required>
                                                            <option value="">Pilih Instansi</option>
                                                        @foreach($instansis as $instansi)
                                                            <option value="{{$instansi->id}}">{{ $instansi->nama_instansi }}</option>
                                                        @endforeach
                                                    </select>
                                                    <p class="text-danger animated slideInUp"><small>{{ $errors->first('instansi') }}</small></p>
                                                @else
                                                    <select name="instansi" id="#instansi_input" onchange="" type="text" placeholder="Pilih sekolah" class="browser-default custom-select" required>
                                                        <option value="">Pilih Instansi</option>
                                                        @foreach($instansis as $instansi)
                                                            <option value="{{$instansi->id}}">{{ $instansi->nama_instansi }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                        </div>
                                        
                                        <div id="sekolah_wrapper" style="display:none;">
                                            <label for="exampleForm2" class="mt-2" data-toggle="tooltip" title="Tipe / Jenjang Sekolah">Tipe Sekolah <span class="text-danger"> * </span><i class="fas fa-question-circle"></i></label>
                                            @if($errors->has('tipe_sekolah'))
                                                <select name="tipe_sekolah" id="tipe_sekolah_input" onchange="ajaxGetSekolah(this.value)" type="text" placeholder="Pilih tipe_sekolah" class="browser-default custom-select border border-danger" disabled required>
                                                    @if(isset($tipe_sekolahs))
                                                        @foreach($tipe_sekolahs as $tipe_sekolah)
                                                            <option value="{{ $tipe_sekolah->id }}">{{ strtoupper($tipe_sekolah->nama_tipe) }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <p class="text-danger animated slideInUp"><small>{{ $errors->first('tipe_sekolah') }}</small></p>
                                            @else
                                                <select name="tipe_sekolah" id="tipe_sekolah_input" onchange="ajaxGetSekolah(this.value)" type="text" placeholder="Pilih tipe_sekolah" class="browser-default custom-select" disabled required>
                                                    <option value="">Pilih Tipe Sekolah</option>
                                                    @if(isset($tipe_sekolahs))
                                                        @foreach($tipe_sekolahs as $tipe_sekolah)
                                                            <option value="{{ $tipe_sekolah->id }}">{{ strtoupper($tipe_sekolah->nama_tipe) }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            @endif

                                            <label for="exampleForm2" class="mt-2" data-toggle="tooltip" title="Sekolah asal pendaftar">Sekolah <span class="text-danger"> * </span><i class="fas fa-question-circle"></i></label>
                                            @if($errors->has('sekolah'))
                                                <select name="sekolah" id="sekolah_input" type="text" placeholder="Pilih sekolah" class="browser-default custom-select border border-danger" disabled required>
                                                        <option value="">Pilih Sekolah</option>
                                                </select>
                                                <p class="text-danger animated slideInUp"><small>{{ $errors->first('sekolah') }}</small></p>
                                            @else
                                                <select name="sekolah" id="sekolah_input" type="text" placeholder="Pilih sekolah" class="browser-default custom-select" disabled required>
                                                        <option value="">Pilih Sekolah</option>
                                                </select>
                                            @endif
                                        </div>

                                        <div id="universitas_wrapper" style="display:none;">
                                            <label for="exampleForm2" class="mt-2" data-toggle="tooltip" title="universitas asal pendaftar apabila tidak berasal dari universitas yang ada silahkan pilih opsi UMUM">Universitas <span class="text-danger"> * </span><i class="fas fa-question-circle"></i></label>
                                            @if($errors->has('universitas'))
                                                <select name="universitas" id="universitas_input" onchange="ajaxGetFakultas(this.value)" type="text" placeholder="Pilih universitas" class="browser-default custom-select border border-danger" required>
                                                    <option value="">Pilih Universitas</option>
                                                    @foreach($universitas as $univ)
                                                        <option value="{{ $univ->id }}">{{ $univ->nama_universitas }}</option>
                                                    @endforeach
                                                </select>
                                                <p class="text-danger animated slideInUp"><small>{{ $errors->first('universitas') }}</small></p>
                                            @else
                                                <select name="universitas" id="universitas_input" onchange="ajaxGetFakultas(this.value)" type="text" placeholder="Pilih universitas" class="browser-default custom-select" required>
                                                    <option value="">Pilih Universitas </option>
                                                    @foreach($universitas as $univ)
                                                        <option value="{{ $univ->id }}">{{ $univ->nama_universitas }}</option>
                                                    @endforeach
                                                </select>
                                            @endif

                                            <label class="mt-2" data-toggle="tooltip" title="Fakultas tempat pendaftar menempuh pendidikan, abaikan apabila bukan berasal dari instansi universitas / umum ">Fakultas <span class="text-danger"> * </span> <i class="fas fa-question-circle"></i></label>
                                            @if($errors->has('fakultas'))
                                                <select name="fakultas" onchange="ajaxGetProdi(this.value)"  id="fakultas_input" type="text" placeholder="Pilih fakultas" class="browser-default custom-select border border-danger" disabled required>
                                                    <option value="">Pilih Fakultas</option>
                                                </select>
                                                <p class="text-danger animated slideInUp"><small>{{ $errors->first('fakultas') }}</small></p>
                                            @else
                                                <select name="fakultas" onchange="ajaxGetProdi(this.value)"  id="fakultas_input" type="text" placeholder="Pilih fakultas" class="browser-default custom-select" disabled required>
                                                    <option value="">Pilih Fakultas</option>
                                                </select>
                                            @endif

                                            <label class="mt-2" data-toggle="tooltip" title="Program Studi tempat pendaftar menempuh pendidikan, abaikan apabila bukan berasal dari instansi universitas / umum">Program Studi <span class="text-danger"> * </span> <i class="fas fa-question-circle"></i></label>
                                            @if($errors->has('prodi'))
                                                <select name="prodi" id="prodi_input" type="text" placeholder="Pilih Program Studi" class="browser-default custom-select border border-danger" disabled required>
                                                    <option value="">Pilih Prodi</option>
                                                </select>
                                                <p class="text-danger animated slideInUp"><small>{{ $errors->first('prodi') }}</small></p>
                                            @else
                                                <select name="prodi" id="prodi_input" type="text" placeholder="Pilih Program Studi" class="browser-default custom-select" disabled required>
                                                    <option value="">Pilih Prodi</option>
                                                </select>
                                            @endif
                                        </div>

                                        <label class="mt-2">Email</label>
                                        <input name="email" type="text" class="form-control @error('email') border border-danger @enderror" value="{{ $user->email }}">
                                        @error('email') <p class="p-0 m-0 text-danger"><small>{{ $errors->first('email') }}</small></p> @enderror

                                        <label class="mt-2">Phone Number</label>
                                        <input name="phone_number" type="tel" class="form-control @error('phone_number') border border-danger @enderror" value="{{ $user->phone_number }}" pattern="/(\+62)([0-9]*$)/" minlength="7" maxlength="15" >
                                        @error('phone_number') <p class="p-0 m-0 text-danger"><small>{{ $errors->first('phone_number') }}</small></p> @enderror

                                        <label class="mt-2">Line</label>
                                        <input name="line" type="text" class="form-control @error('line') border border-danger @enderror" value="{{ $user->line }}">
                                        @error('line') <p class="p-0 m-0 text-danger"><small>{{ $errors->first('line') }}</small></p> @enderror


                                        <label class="mt-2">WA</label>
                                        <input name="wa" type="tel" class="form-control @error('wa') border border-danger @enderror" value="{{ $user->wa }}" pattern="/(\+62)([0-9]*$)/" minlength="7" maxlength="15" >
                                        @error('wa') <p class="p-0 m-0 text-danger"><small>{{ $errors->first('wa') }}</small></p> @enderror


                                        <label class="mt-2">Alamat</label>
                                        <input name="alamat" type="text" class="form-control @error('alamat') border border-danger @enderror" value="{{ $user->alamat }}">
                                        @error('alamat') <p class="p-0 m-0 text-danger"><small>{{ $errors->first('alamat') }}</small></p> @enderror

                                        <label class="mt-2">Kartu Identitas [{{ strtoupper($user->jenis_kartu_identitas) }}]</label> 
                                        <a target="__blank" href="{{ asset('storage/kartu_identitas').'/'.$user->kartu_identitas }}" class="btn btn-block btn-info">LIHAT KARTU IDENTITAS SAAT INI</a>

                                        <div class="input-group my-3 @error('file_kartu_identitas') border border-danger @enderror">
                                            <div class="input-group-prepend d-none d-lg-block">
                                                <span class="input-group-text" id="inputGroupFileAddon01">File Kartu Identitas</span>
                                            </div>
                                            <div class="custom-file">
                                                <input name="kartu_identitas" type="file" class="custom-file-input" id="inputGroupFile01"
                                                aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="inputGroupFile01">Ganti File Kartu Identitas</label>
                                            </div>
                                        </div>
                                        @error('kartu_identitas') <p class="p-0 m-0 text-danger"><small>{{ $errors->first('kartu_identitas') }}</small></p> @enderror

                                        <label data-toggle="tooltip" title="Input file kartu pengenal anda, dapat menggunakan KTP/NISN/KTM/PASSPORT. Mohon untuk memilih opsi jenis kartu sesuai dengan apa yang pendaftar input">Pilih Jenis Kartu yang telah diinput<span class="text-danger"> * </span><i class="fas fa-question-circle"></i></label>

                                        <!-- Group of default radios - option 1 -->
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="defaultGroupExample1" name="jenis_kartu_identitas" value="ktp" required @if($user->jenis_kartu_identitas == 'ktp') checked @endif>
                                            <label class="custom-control-label" for="defaultGroupExample1">KTP</label>
                                        </div>

                                        <!-- Group of default radios - option 2 -->
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" class="custom-control-input" id="defaultGroupExample2" name="jenis_kartu_identitas" value="nisn" required @if($user->jenis_kartu_identitas == 'nisn') checked @endif>
                                            <label class="custom-control-label" for="defaultGroupExample2">NISN</label>
                                        </div>

                                        <!-- Group of default radios - option 2 -->
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" class="custom-control-input" id="defaultGroupExample3" name="jenis_kartu_identitas" value="ktm" required @if($user->jenis_kartu_identitas == 'ktm') checked @endif>
                                            <label class="custom-control-label" for="defaultGroupExample3">KTM (Kartu Tanda Mahasiswa)</label>
                                        </div>

                                        <!-- Group of default radios - option 3 -->
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" class="custom-control-input" id="defaultGroupExample4" name="jenis_kartu_identitas" value="passport" required @if($user->jenis_kartu_identitas == 'passport') checked @endif>
                                            <label class="custom-control-label" for="defaultGroupExample4">PASSPORT</label>
                                        </div>
                                        @error('jenis_kartu_identitas') <p class="text-danger"><small>{{ $errors->first('jenis_kartu_identitas') }}</small></p>@enderror

                                        <label class="mt-3">Password</label> 
                                        <input name="password" type="pasword" placeholder="Isi Untuk Mengganti Password Siswa (Kosongkan apabila tidak ingin mengganti)" class="form-control @error('password') border border-danger @enderror" value="">
                                        @error('password') <p class="p-0 m-0 text-danger"><small>{{ $errors->first('password') }}</small></p> @enderror

                                        <label class="mt-2">Password Confirmation</label> 
                                        <input name="password_confirmation" type="pasword" placeholder="Isi Untuk Mengganti Password Siswa (Kosongkan apabila tidak ingin mengganti)" class="form-control @error('password_confirmation') border border-danger @enderror" value="">
                                        @error('password_confirmation') <p class="p-0 m-0 text-danger"><small>{{ $errors->first('password_confirmation') }}</small></p> @enderror
                                        
                                        <label class="mt-2" data-toggle="tooltip" title="apabila di tidak aktifkan user tidak akan bisa masuk ke dalam sistem namun masih terdata di dalam kelas apabila mengikuti kelas">Hak Akses <i class="far fa-question-circle"></i></label>
                                        <select name="hak_akses" class="browser-default custom-select @error('hak_akses') border border-danger @enderror">
                                            <option>Pilih Hak Akses</option>
                                            <option value="aktif" @if($user->hak_akses == 'aktif') selected @endif>AKTIF</option>
                                            <option value="ban" @if($user->hak_akses == 'ban') selected @endif>BAN</option>
                                        </select>
                                        @error('hak_akses') <p class="p-0 m-0 text-danger"><small>{{ $errors->first('hak_akses') }}</small></p> @enderror


                                        <button onclick="peringatanAdmin()" class="btn btn-block btn-primary mt-3" type="button">SUBMIT</button>
                                        <a href="{{ route('admin.siswa') }}" type="button" class="btn btn-block btn-danger mt-3">KEMBALI</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready( function () {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        @if(old('status') !== null)
            @if(old('status') == 'siswa')
                $('#sekolah_wrapper').css('display','block');
                resetSiswa();
            @elseif(old('status') == 'mahasiswa')
                $('#universitas_wrapper').css('display','block');
                resetMahasiswa();
            @elseif(old('status') == 'instansi')
                $('#instansi_wrapper').css('display','block');
                resetInstansi();
            @endif
        @endif
    });

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

    function hideInputSystem(status){
        if(status == 'siswa'){
            resetSiswa();
            $('#universitas_wrapper').css('display','none');
            $('#universitas_wrapper select').prop('disabled',true);
            $('#instansi_wrapper').css('display','none');
            $('#instansi_wrapper select').prop('disabled',true);
            $('#sekolah_wrapper').css('display','block');
            $('#sekolah_wrapper select:eq(0)').prop('disabled',false);

        }else if(status == 'mahasiswa'){
            resetMahasiswa();
            $('#universitas_wrapper').css('display','block');
            $('#universitas_wrapper select:eq(0)').prop('disabled',false);
            $('#instansi_wrapper').css('display','none');
            $('#instansi_wrapper select').prop('disabled',true);
            $('#sekolah_wrapper').css('display','none');
            $('#sekolah_wrapper select').prop('disabled',true);

        }else if(status == 'instansi' ){
            resetInstansi();
            $('#universitas_wrapper').css('display','none');
            $('#universitas_wrapper select').prop('disabled',true);
            $('#instansi_wrapper').css('display','block');
            $('#instansi_wrapper select:eq(0)').prop('disabled',false);
            $('#sekolah_wrapper').css('display','none');
            $('#sekolah_wrapper select').prop('disabled',true);

        }else{

            $('#universitas_wrapper').css('display','none');
            $('#universitas_wrapper select').prop('disabled',true);
            $('#instansi_wrapper').css('display','none');
            $('#instansi_wrapper select').prop('disabled',true);
            $('#sekolah_wrapper').css('display','none');
            $('#sekolah_wrapper select').prop('disabled',true);

        }
    }

    // MAHASISWA
        function ajaxGetFakultas(id_universitas){
            // RESET VALUE FAKULTAS DAN PRODI
            $('#fakultas_input').html('<option value="">Pilih Fakultas</option>');
            $('#fakultas_input').val('');
            $('#fakultas_input').prop('disabled',true);
            $('#prodi_input').html('<option value="">Pilih Prodi</option>')
            $('#prodi_input').val('');
            $('#prodi_input').prop('disabled',true);

            // APABILA NILAI ID TIDAK SAMA DENGAN NULL DAN TIDAK KOSONG MAKA AKAN MENGIRIM AJAX REQUEST
            if(id_universitas != "" && id_universitas != null){
                $.ajax({
                    data : {
                        '_token' : "{{ csrf_token() }}",
                        'id' : id_universitas
                    },

                    method: "POST",

                    url: "{{ Route('user.ajax.getFakultas') }}",

                    }).done(function( msg ) {
                        try{
                            console.log(msg)
                            if(msg.universitas.fakultas.length > 0){
                                showFakultas(msg.universitas.fakultas);
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Opps...',
                                    text: 'Tidak ada data fakultas, mohon hubungi admin sistem',
                                });
                            }
                        }catch(err){
                            console.log(err)
                        }
                    }).fail(function(msg){
                        Swal.fire({
                            icon: 'error',
                            title: 'Opps...',
                            text: 'Terjadi Kesalahan, apabila diperlukan silahkan menghubungi team pengembang pada halaman Contact',
                        });
                    });
            }

        }

        function showFakultas(fakultas){
            let fakultas_option = '<option value="" selected>Pilih Fakultas</option>';
            
            $('#fakultas_input').prop('disabled',false);

            fakultas.forEach(function(fakult){
                try{
                    fakultas_option += '<option value="'+fakult.id+'">'+fakult.nama_fakultas+'</option>'
                }catch(err){
                    return
                };
            });

            $('#fakultas_input').html(fakultas_option);
        }

        function ajaxGetProdi(id_fakultas){
            // RESET VALUE FAKULTAS DAN PRODI
            $('#prodi_input').html('<option value="">Pilih Prodi</option>')
            $('#prodi_input').val('');
            $('#prodi_input').prop('disabled',true);

            // APABILA NILAI ID TIDAK SAMA DENGAN NULL DAN TIDAK KOSONG MAKA AKAN MENGIRIM AJAX REQUEST
            if(id_fakultas != '' && id_fakultas != null){
                $.ajax({
                    data : {
                        '_token' : "{{ csrf_token() }}",
                        'id' : id_fakultas
                    },

                    method: "POST",

                    url: "{{ Route('user.ajax.getProdi') }}",

                    }).done(function( msg ) {
                        try{
                            if(msg.status == 200 && msg.prodi.length > 0){
                                showProdi(msg.prodi);
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Opps...',
                                    text: 'Belum ada data prodi di database, mohon hubungi admin sistem',
                                });
                            }
                        }catch(err){
                            console.log(err)
                        }
                    }).fail(function(msg){
                        Swal.fire({
                            icon: 'error',
                            title: 'Opps...',
                            text: 'Terjadi Kesalahan, apabila diperlukan silahkan menghubungi team pengembang pada halaman Contact',
                        });
                    });
            }

        }

        function showProdi(prodis){
            let prodi_option = '<option value="" selected>Pilih Prodi</option>';

            $('#prodi_input').prop('disabled',false);

            prodis.forEach(function(prodi){
                try{
                    prodi_option += '<option value="'+prodi.id+'">'+prodi.nama_prodi+'</option>'
                }catch(err){
                    return
                };
            });

            $('#prodi_input').html(prodi_option);
        }

        function resetMahasiswa(){
            $('#universitas_input').val("").change();
            $('#universitas_input').trigger('click');
        }
    // AKHIR

    // SISWA
        function ajaxGetSekolah(id_tipe_sekolah){
            // RESET VALUE FAKULTAS DAN PRODI
            $('#sekolah_input').html('<option value="">Pilih Sekolah</option>');
            $('#sekolah_input').val('');
            $('#sekolah_input').prop('disabled',true);

            // APABILA NILAI ID TIDAK SAMA DENGAN NULL DAN TIDAK KOSONG MAKA AKAN MENGIRIM AJAX REQUEST
            if(id_tipe_sekolah != "" && id_tipe_sekolah != null){
                $.ajax({
                    data : {
                        '_token' : "{{ csrf_token() }}",
                        'id' : id_tipe_sekolah
                    },

                    method: "POST",

                    url: "{{ Route('user.ajax.getSekolah') }}",

                    }).done(function( msg ) {
                        try{
                            console.log(msg)
                            if(msg.sekolahs.length > 0){
                                showSekolah(msg.sekolahs);
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Opps...',
                                    text: 'Tidak ada data sekolah, Apabila diperlukan mohon hubungi admin sistem',
                                });
                            }
                        }catch(err){
                            console.log(err)
                        }
                    }).fail(function(msg){
                        Swal.fire({
                            icon: 'error',
                            title: 'Opps...',
                            text: 'Terjadi Kesalahan, apabila diperlukan silahkan menghubungi team pengembang pada halaman Contact',
                        });
                    });
            }

        }

        function showSekolah(sekolahs){
            let sekolah_option = '<option value="" selected>Pilih Sekolah</option>';

            $('#sekolah_input').prop('disabled',false);

            sekolahs.forEach(function(sekolah){
                try{
                    sekolah_option += '<option value="'+sekolah.id+'">'+sekolah.nama_sekolah+'</option>'
                }catch(err){
                    return
                };
            });

            $('#sekolah_input').html(sekolah_option);
        }

        function resetSiswa(){
            $('#tipe_sekolah_input').val("").change();
            $('#tipe_sekolah_input').trigger('click');
        }
    // AKHIR

    // INSTANSI
        function resetInstansi(){
            $('#instansi_input').val("").change();
            $('#instansi_input').trigger('click');
        }
    // END

    function peringatanAdmin(){
        Swal.fire({
        title: 'Peringatan Admin !',
        html: 
        '<p>Berikut merupakan effect apabila admin melakukan edit user</p>'+
        '<ul class="text-left">'+
        '<li>User tidak akan mendapatkan notifikasi perubahan, apabila diperlukan mohon untuk memberitahu user secara out system</li>'+
        '<li>Admin dapat mengganti password user, jadi mohon gunakan fitur dengan bijak</li>'+
        '<li>Admin dapat merubah instansi user, namun kelas yang sudah terlanjut diikuti dengan instansi user sebelumnya masih tetap dapat diakses oleh user</li>'+
        '<li>WA, Line, Nomor HP, E-mail dapat dirubah oleh admin jadi mohon dicek kebenaran data</li>'+
        '<li class="text-danger">Rekam data sebelumnya akan hilang sepenuhnya dan tidak dapat dikembalikan</li>'+
        '</ul>'
        ,
        icon:'warning',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: `Update`,
        denyButtonText: `Batal`,
        }).then((result) => {
            
        if (result.isConfirmed) {
            $('#edit-user').submit();
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