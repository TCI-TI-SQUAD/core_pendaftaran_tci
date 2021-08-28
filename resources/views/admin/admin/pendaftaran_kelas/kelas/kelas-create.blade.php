@extends('admin.admin-layout.admin-layout')

@section('pendaftaran_kelas','active')

@section('page-name-header','Create Kelas')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.pendaftarankelas') }}">Pendaftaran Kelas</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.detail.pendaftarankelas',[$pendaftaran->id]) }}">Detail Pendaftaran Kelas</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.kelas',[$pendaftaran->id]) }}">Kelas</a></li>
<li class="breadcrumb-item active">Create Kelas</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 jumbotron shadow p-2 mt-2">
        <div class="container-fluid">
            <form action="{{ route('admin.post.create.kelas') }}" method="POST" enctype="multipart/form-data" onsubmit="myButton.disabled = true; return true;">
                <input type="hidden" value="{{ $pendaftaran->id }}" name="id">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-12 text-center text-lg-left">
                        <h5>FORM CREATE KELAS</h5>
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="mt-2" for="exampleForm1">NAMA KELAS</label>
                        <input name="nama_kelas" type="text" id="exampleForm1" class="form-control @error('nama_kelas') border border-danger @enderror" placeholder="Masukkan Nama Kelas">
                        @error('nama_kelas') <p class="p-m m-0 text-danger"><small>{{ $errors->first('nama_kelas') }}</small></p> @enderror

                        <label>HSK</label>
                        <select class="selectpicker w-100 @error('hsk') border border-danger @enderror" name="hsk">
                            <option value="">Pilih HSK</option>
                            <option value="pemula" @if(old('status') == 'pemula') selected @endif>pemula</option>
                            <option value="hsk 1" @if(old('status') == 'hsk 1') selected @endif>HSK 1</option>
                            <option value="hsk 2" @if(old('status') == 'hsk 2') selected @endif>HSK 2</option>
                            <option value="hsk 3" @if(old('status') == 'hsk 3') selected @endif>HSK 3</option>
                            <option value="hsk 4" @if(old('status') == 'hsk 4') selected @endif>HSK 4</option>
                            <option value="hsk 5" @if(old('status') == 'hsk 5') selected @endif>HSK 5</option>
                            <option value="hsk 6" @if(old('status') == 'hsk 6') selected @endif>HSK 6</option>
                        </select>
                        @error('hsk') <p class="text-danger m-0 p-0"><small>{{ $errors->first('hsk') }}</small></p> @enderror

                        <label class="mt-2 @error('tanggal_mulai') border border-danger @enderror" for="exampleForm2">TANGGAL MULAI KELAS</label>
                        <input name="tanggal_mulai" type="date" id="exampleForm2" class="form-control">
                        @error('tanggal_mulai') <p class="text-danger m-0 p-0"><small>{{ $errors->first('tanggal_mulai') }}</small></p> @enderror
                        
                        <label class="mt-2" for="exampleForm3">TANGGAL SELESAI KELAS</label>
                        <input name="tanggal_selesai" type="date" id="exampleForm3" class="form-control @error('tanggal_selesai') border border-danger @enderror">
                        @error('tanggal_selesai') <p class="text-danger m-0 p-0"><small>{{ $errors->first('tanggal_selesai') }}</small></p> @enderror

                        <label class="mt-2">KELAS BERBAYAR</label>
                        <div class="custom-control custom-checkbox text-center @error('isberbayar') border border-danger @enderror" onchange="showInputHarga()">
                            <input name="isberbayar" type="checkbox" class="custom-control-input" id="defaultUnchecked" value="1">
                            <label class="custom-control-label" for="defaultUnchecked">CENTANG APABILA IYA</label>
                            @error('isberbayar') <p class="text-danger m-0 p-0"><small>{{ $errors->first('isberbayar') }}</small></p> @enderror
                        </div>
                        
                        <div id="input_harga" class="d-none">
                            <label class="mt-2">HARGA</label>
                            <div class="input-group mb-2 @error('harga') border border-danger @enderror">
                                <div class="input-group-prepend">
                                <div class="input-group-text">Rp. </div>
                                </div>
                                <input value="{{ old('harga') }}" name="harga" id="money" type="text" class="form-control" id="inlineFormInputGroup" placeholder="Harga Pendaftaran Kelas">
                            </div>
                            @error('harga') <p class="m-0 p-0 text-danger"><small>{{ $errors->first('harga') }}</small></p>@enderror
                        </div>

                        <label class="mt-2" for="exampleForm3">KUOTA</label>
                        <input name="kuota" type="number" id="exampleForm3" class="form-control @error('kuota') border border-danger @enderror" placeholder="Kuota maksimal kelas">
                        @error('kuota') <p class="m-0 p-0 text-danger"><small>{{ $errors->first('kuota') }}</small></p> @enderror

                        <label class="mt-2">IMAGE KELAS</label>
                        <div class="custom-file @error('logo_kelas') border border-danger @enderror">
                            <input name="logo_kelas" id="image_kelas" type="file" class="custom-file-input" id="validatedCustomFile">
                            <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                        </div>
                        @error('logo_kelas') <p class="m-0 p-0 text-danger"><small>$errors->first('logo_kelas')</small></p> @enderror

                        <div class="col-12 p-0 m-0 mt-2">
                            <label>DAPAT DIAKSES</label>
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">UMUM</h3>
                                        <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check form-check-inline p-2">
                                            <input class="form-check-input" type="checkbox" name="umum[]" id="inlineRadio3" value="0">
                                            <label class="form-check-label" for="inlineRadio3">UMUM</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">MAHASISWA</h3>
                                        <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @if(isset($prodis))
                                            @if($prodis->count()>0)
                                                @foreach($prodis as $index => $prodi)
                                                    <div class="form-check form-check-inline p-2">
                                                        <input class="form-check-input prodi-checkbox" type="checkbox" name="prodi[]" value="{{$prodi->id}}">
                                                        <label class="form-check-label" for="inlineRadio3">{{ $prodi->getFullProdiName() }}</label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endif
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-sm btn-primary" onclick="$('.prodi-checkbox').click()" type="button">SEMUA SEKOLAH</button>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">SISWA</h3>
                                        <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @if(isset($sekolahs))
                                            @if($sekolahs->count()>0)
                                                @foreach($sekolahs as $index => $sekolah)
                                                    <div class="form-check form-check-inline p-2">
                                                        <input class="form-check-input sekolah-checkbox" type="checkbox" name="sekolah[]" value="{{$sekolah->id}}">
                                                        <label class="form-check-label" for="inlineRadio3">{{ $sekolah->nama_sekolah }}</label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endif
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-sm btn-primary" onclick="$('.sekolah-checkbox').click()" type="button">SEMUA SEKOLAH</button>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">INSTANSI</h3>
                                        <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @if(isset($instansis))
                                            @if($instansis->count()>0)
                                                @foreach($instansis as $index => $instansi)
                                                    <div class="form-check form-check-inline p-2">
                                                        <input class="form-check-input instansi-checkbox" type="checkbox" name="instansi[]" value="{{$instansi->id}}">
                                                        <label class="form-check-label" for="inlineRadio3">{{ $instansi->nama_instansi }}</label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endif
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-sm btn-primary" onclick="$('.instansi-checkbox').click()" type="button">SEMUA SEKOLAH</button>
                                    </div>
                                </div>
                        </div>
                        
                        <label>STATUS</label>
                        <select class="selectpicker w-100 @error('status') border border-danger @enderror" name="status">
                            <option value="">Pilih Status Pendaftaran</option>
                            <option value="buka" @if(old('status') == 'buka') selected @endif>BUKA</option>
                            <option value="tutup" @if(old('status') == 'tutup') selected @endif>TUTUP</option>
                        </select>
                        @error('status') <p class="text-danger m-0 p-0"><small>{{ $errors->first('status') }}</small></p> @enderror
                        
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="mt-2">Pengajar</label>
                        <select class="selectpicker w-100 @error('id_pengajar') border border-danger @enderror" name="id_pengajar">
                            <option value="">Pilih Pengajar</option>
                            @if(isset($pengajars))
                                @if($pengajars->count() > 0)
                                    @foreach($pengajars as $index => $pengajar)
                                        <option value="{{ $pengajar->id }}" @if(old('status') == 'aktif') selected @endif>{{ $pengajar->nama_pengajar }}</option>
                                    @endforeach
                                @endif
                            @endif
                        </select>
                        @error('id_pengajar') <p class="m-0 p-0 text-danger"><small>{{ $errors->first('id_pengajar') }}</small></p> @enderror

                        <div class="card mt-3">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="font-weight-bold text-center bg-primary p-2">JADWAL KELAS</h5>
                                </div>
                                <div class="col-12 text-right">
                                    <button type="button" class="btn btn-sm btn-danger p-2 mx-1" onclick="removeJadwal()"><i class="fas fa-minus"></i> KURANGI</button>
                                    <button type="button" class="btn btn-sm btn-primary p-2 mx-1" onclick="addJadwal()"><i class="fas fa-plus"></i> TAMBAH</button>
                                </div>
                            </div>
                            <div class="row text-center mt-3 p-2 d-none d-lg-flex">
                                <div class="col-4">
                                    <label for="">HARI</label>
                                </div>

                                <div class="col-4">
                                    <label for="">WAKTU MULAI</label>
                                </div>

                                <div class="col-4">
                                    <label for="">WAKTU SELESAI</label>
                                </div>
                            </div>
                            <div class="container jadwal-container">
                                <div class="row p-2 jadwal-wrapper">
                                    <div class="col-12 col-lg-4">
                                        <label class="d-block d-lg-none m-2">HARI</label>
                                        <select class="custom-select w-100" name="jadwal[day][]">
                                            <option value="">Pilih Hari</option>
                                            <option value="sunday">SUNDAY</option>
                                            <option value="monday">MONDAY</option>
                                            <option value="tuesday">TUESDAY</option>
                                            <option value="wednesday">WEDNESDAY</option>
                                            <option value="thursday">THURSDAY</option>
                                            <option value="friday">FRIDAY</option>
                                            <option value="saturday">SATURDAY</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-12">
                                        <label class="d-block d-lg-none m-2">WAKTU MULAI</label>
                                        <input type="time" class="form-control" name="jadwal[waktu_mulai][]">
                                    </div>

                                    <div class="col-lg-4 col-12">
                                        <label class="d-block d-lg-none m-2">WAKTU SELESAI</label>
                                        <input type="time" class="form-control" name="jadwal[waktu_selesai][]">
                                    </div>

                                    <div class="bg-primary w-100 my-3" style="height:2px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-center mt-3">
                        <button class="btn btn-md w-100 d-lg-none d-inline-block btn-primary" type="submit" name="myButton">KIRIM</button>
                        <a href="{{ route('admin.kelas',[$pendaftaran->id]) }}" class="btn btn-md w-25 d-lg-inline-block d-none btn-danger">BATAL</a>
                        <a href="{{ route('admin.kelas',[$pendaftaran->id]) }}" class="btn btn-md w-100 mt-3 d-lg-none d-inline-block btn-danger">BATAL</a>
                        <button class="btn btn-md w-25 d-lg-inline-block d-none btn-primary" type="submit"name="myButton" >KIRIM</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
<style>
.note-group-select-from-files {
  display: none;
}
</style>
@push('css')

@endpush

@push('js')
<script src="{{ asset('asset\js\maskMoney\maskMoney.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("[data-card-widget='collapse']").click()
    });

    $("#money").maskMoney({
            precision:0,
            thousands:".",
            decimal:",",
            allowEmpty:true,
    });  

    $('#image_kelas').on('change',function(){
        var fileName = $(this).val();
        $(this).next('.custom-file-label').html(fileName);
    })

    function showInputHarga(){
        $("#input_harga").toggleClass("d-none");
    }

    function addJadwal(){
        $( ".jadwal-wrapper:first" ).clone().appendTo( ".jadwal-container" );
    }

    function removeJadwal(){
        if($(".jadwal-container").children().length > 1){
            $( ".jadwal-wrapper:last" ).remove();
        }else{
            Swal.fire({
                icon: "warning",
                title: "Harus Menyertakan Jadwal !",
                text: "Kelas setidaknya harus berisikan satu jadwal",
            });
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