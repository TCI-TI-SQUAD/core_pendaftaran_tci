@extends('layout.auth.user-login-template')

@section('form')
            <img src="{{ asset('asset\image\user-login\temple.png') }}" alt="">
            <div class="form-container animated fadeInUp p-3">
                <form action="{{ Route('user.post.register') }}" enctype='multipart/form-data' method="POST" onsubmit="myButton.disabled = true; return true;">
                    {{ csrf_field() }}
                    {{ method_field('post') }}
                    <h4 class="font-weight-bold text-center mt-5" style="margin: auto;">Register</h4>
                    
                    <label class="mt-5">Nama Lengkap <span class="text-danger">*</span></label>
                    @if($errors->has('name'))
                        <input name="name" value="{{ old('name') }}" type="text" placeholder="Sesuai dengan kartu KTP" class="form-control mt-1 border border-danger" minlength="5" maxlength="50" required>
                        <p class="text-danger animated slideInUp"><small>{{ $errors->first('name') }}</small></p>
                    @else
                        <input name="name" value="{{ old('name') }}" type="text" placeholder="Sesuai dengan kartu KTP" class="form-control mt-1" minlength="5" maxlength="50" required>
                    @endif

                    <label class="mt-2">Username <span class="text-danger">*</span></label>
                    @if($errors->has('username'))
                        <input name="username" value="{{ old('username') }}" type="text" placeholder="Penentuan username bebas" class="form-control mt-1 border border-danger" minlength="3" maxlength="15" required>
                        <p class="text-danger animated slideInUp"><small>{{ $errors->first('username') }}</small></p>
                    @else
                        <input name="username" value="{{ old('username') }}" type="text" placeholder="Penentuan username bebas" class="form-control mt-1" minlength="3" maxlength="15" required>
                    @endif

                    <label class="mt-2">Email <span class="text-danger">*</span></label>
                    @if($errors->has('email'))
                        <input name="email" value="{{ old('email') }}" type="email" class="form-control mt-1 border border-danger" minlength="5" maxlength="50" required>
                        <p class="text-danger animated slideInUp"><small>{{ $errors->first('email') }}</small></p>
                    @else
                        <input name="email" value="{{ old('email') }}" type="email" class="form-control mt-1" minlength="5" maxlength="50" required>
                    @endif
                    
                    <label class="mt-2">Phone Number <span class="text-danger">*</span></label>
                    @if($errors->has('phone_number'))
                        <input name="phone_number" value="{{ old('phone_number') }}" type="number" placeholder="Ex. +62999999999 " class="form-control mt-1 border border-danger" pattern="\d*" minlength="7" maxlength="15" required>
                        <p class="text-danger animated slideInUp"><small>{{ $errors->first('phone_number') }}</small></p>
                    @else
                        <input name="phone_number" value="{{ old('phone_number') }}" type="number" placeholder="Ex. +62999999999 " class="form-control mt-1" pattern="\d*" minlength="7" maxlength="15" required>
                    @endif 

                    <label for="exampleForm2" class="mt-2">Line ID <span class="text-danger">*</span></label>
                    @if($errors->has('line'))
                        <input name="line" value="{{ old('line') }}" type="text" placeholder="ID Line Aktif" class="form-control mt-1 border border-danger" minlength="3" maxlength="50" required>
                        <p class="text-danger animated slideInUp"><small>{{ $errors->first('line') }}</small></p>
                    @else
                        <input name="line" value="{{ old('line') }}" type="text" placeholder="ID Line Aktif" class="form-control mt-1" minlength="3" maxlength="50" required>
                    @endif
                    
                    <label for="exampleForm2" class="mt-2" data-toggle="tooltip" title="Nomor WA yang terintegrasi dengan account WA">WA Number <span class="text-danger"> * </span><i class="fas fa-question-circle"></i></label>
                    @if($errors->has('wa'))
                        <input name="wa" value="{{ old('wa') }}" type="number" placeholder="Nomor HP terhubung WA" class="form-control mt-1 border border-danger" pattern="\d*" minlength="7" maxlength="15" required>
                        <p class="text-danger animated slideInUp"><small>{{ $errors->first('wa') }}</small></p>
                    @else
                        <input name="wa" value="{{ old('wa') }}" type="number" placeholder="Nomor HP terhubung WA" class="form-control mt-1" pattern="\d*" minlength="7" maxlength="15" required>
                    @endif

                    <label for="exampleForm2" class="mt-2" data-toggle="tooltip" title="Alamat tempat tinggal pendaftar">Alamat <span class="text-danger"> * </span><i class="fas fa-question-circle"></i></label>
                    @if($errors->has('alamat'))
                        <input name="alamat" value="{{ old('alamat') }}" type="text" placeholder="Alamat tempat tinggal lengkap" class="form-control mt-1 border border-danger" minlength="5" maxlength="50" required>
                        <p class="text-danger animated slideInUp"><small>{{ $errors->first('alamat') }}</small></p>
                    @else
                        <input name="alamat" value="{{ old('alamat') }}" type="text" placeholder="Alamat tempat tinggal lengkap" class="form-control mt-1" minlength="5" maxlength="50" required>
                    @endif

                    <hr style="height:1px;background:red;">

                    <label for="exampleForm2" class="mt-1" data-toggle="tooltip" title="Masukkan password anda pada field ini">Password <span class="text-danger"> * </span><i class="fas fa-question-circle"></i></label>
                    @if($errors->has('password'))
                        <input name="password" type="password" placeholder="8-50 karakter" class="form-control mt-1 border border-danger" minlength="5" maxlength="100" required>
                        <p class="text-danger animated slideInUp"><small>{{ $errors->first('password') }}</small></p>
                    @else
                        <input name="password" type="password" placeholder="8-50 karakter" class="form-control mt-1" minlength="5" maxlength="100" required>
                    @endif

                    <label for="exampleForm2" class="mt-2" data-toggle="tooltip" title="Ulangi password anda pada field ini">Password Confirmation <span class="text-danger"> * </span><i class="fas fa-question-circle"></i></label>
                    @if($errors->has('password_confirmation'))
                        <input name="password_confirmation" type="password" placeholder="8-50 karakter" class="form-control mt-1 border border-danger" minlength="5" maxlength="100" required>
                        <p class="text-danger animated slideInUp"><small>{{ $errors->first('password_confirmation') }}</small></p>
                    @else
                        <input name="password_confirmation" type="password" placeholder="8-50 karakter" class="form-control mt-1" minlength="5" maxlength="100" required>
                    @endif

                    <hr style="height:1px;background:red;">

                    <label for="exampleForm2" class="mt-2" data-toggle="tooltip" title="Status pendaftar saat ini">Status <span class="text-danger"> * </span><i class="fas fa-question-circle"></i></label>
                    @if($errors->has('status'))
                        <select name="status" onchange="hideInputSystem(this.value)" type="text" placeholder="Pilih status" class="browser-default custom-select border border-danger" required>
                            <option value="">Pilih Status</option>
                            <option value="umum" @if(old("status") == "umum") selected @endif>Umum</option>
                            <option value="siswa" @if(old("status") == "siswa") selected @endif>Siswa</option>
                            <option value="mahasiswa" @if(old("status") == "mahasiswa") selected @endif>Mahasiswa</option>
                            <option value="instansi" @if(old("status") == "instansi") selected @endif>Instansi Kerjasama</option>
                        </select>
                        <p class="text-danger animated slideInUp"><small>{{ $errors->first('status') }}</small></p>
                    @else
                        <select name="status" onclick="hideInputSystem(this.value)" onchange="hideInputSystem(this.value)" id="status" type="text" placeholder="Pilih status" class="browser-default custom-select" required>
                            <option value="">Pilih Status</option>
                            <option value="umum" @if(old("status") == "umum") selected @endif>Umum</option>
                            <option value="siswa" @if(old("status") == "siswa") selected @endif>Siswa</option>
                            <option value="mahasiswa" @if(old("status") == "mahasiswa") selected @endif>Mahasiswa</option>
                            <option value="instansi" @if(old("status") == "instansi") selected @endif>Instansi Kerjasama</option>
                        </select>
                    @endif

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

                    <hr style="height:1px;background:red;">

                    <label class="mt-1" data-toggle="tooltip" title="Input file kartu pengenal anda, dapat menggunakan KTP/NISN/KTM/PASSPORT. Mohon untuk memilih opsi jenis kartu sesuai dengan apa yang pendaftar input">Kartu Pengenal (KTP/NISN/KTM/PASSPORT) <span class="text-danger"> * </span><i class="fas fa-question-circle"></i></label>
                    @if($errors->has('kartu_identitas'))
                        <div class="custom-file">
                            <input type="file" name="kartu_identitas" accept="image/png, image/gif, image/jpeg" class="custom-file-input" id="customFileLang" lang="en" required>
                            <label class="custom-file-label border border-danger" for="customFileLang">Pilih File Kartu Identitas</label>
                        </div>
                        <p class="text-danger animated slideInUp"><small>{{ $errors->first('kartu_identitas') }}</small></p>
                    @else
                        <div class="custom-file">
                            <input type="file" name="kartu_identitas" accept="image/png, image/gif, image/jpeg" class="custom-file-input" id="customFileLang" lang="en" required>
                            <label class="custom-file-label" for="customFileLang">Pilih File Kartu Identitas</label>
                        </div>
                    @endif

                    <label class="mt-4" data-toggle="tooltip" title="Input file kartu pengenal anda, dapat menggunakan KTP/NISN/KTM/PASSPORT. Mohon untuk memilih opsi jenis kartu sesuai dengan apa yang pendaftar input">Pilih Jenis Kartu yang telah diinput<span class="text-danger"> * </span><i class="fas fa-question-circle"></i></label>

                    <!-- Group of default radios - option 1 -->
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="defaultGroupExample1" name="jenis_kartu_identitas" value="ktp" required>
                        <label class="custom-control-label" for="defaultGroupExample1">KTP</label>
                    </div>

                    <!-- Group of default radios - option 2 -->
                    <div class="custom-control custom-radio mt-2">
                        <input type="radio" class="custom-control-input" id="defaultGroupExample2" name="jenis_kartu_identitas" value="nisn" required>
                        <label class="custom-control-label" for="defaultGroupExample2">NISN</label>
                    </div>

                    <!-- Group of default radios - option 2 -->
                    <div class="custom-control custom-radio mt-2">
                        <input type="radio" class="custom-control-input" id="defaultGroupExample3" name="jenis_kartu_identitas" value="ktm" required>
                        <label class="custom-control-label" for="defaultGroupExample3">KTM (Kartu Tanda Mahasiswa)</label>
                    </div>

                    <!-- Group of default radios - option 3 -->
                    <div class="custom-control custom-radio mt-2">
                        <input type="radio" class="custom-control-input" id="defaultGroupExample4" name="jenis_kartu_identitas" value="passport" required>
                        <label class="custom-control-label" for="defaultGroupExample4">PASSPORT</label>
                    </div>

                    <button name="myButton" class="btn btn-block btn-success mt-5" type="submit">REGISTER</button>
                    <a class="btn btn-block btn-danger mt-1" href="{{ route('user.landing-page') }}">BACK</a>

                    <p class="text-center mt-4">Already have an account ? <a href="{{ Route('user.login') }}">Login Here</a></p>
                    <p class="text-center mt-4">Visit us on</p>

                    <div class="d-flex justify-content-center mb-4">
                        @if(isset($social_medias))
                            @foreach($social_medias as $social_media)
                                <a target="_blank"  data-toggle="tooltip" title="{{ $social_media->keterangan }}" href="{{ $social_media->link }}" class="m-1"><img style="height:30px;width:30px;position:relative;" src="{{ url('asset\image\social-media',[$social_media->social_media_image]) }}" alt="social_media_image"></a>
                            @endforeach
                        @endif
                    </div>
                </form>
            </div>
@endsection

@push('bottom_source')
<script>
    $(document).ready(function(){
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
            $('#instansi_input').reset('trigger');
        }
    // END

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