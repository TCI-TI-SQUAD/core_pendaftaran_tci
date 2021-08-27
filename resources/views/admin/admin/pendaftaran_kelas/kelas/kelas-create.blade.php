@extends('admin.admin-layout.admin-layout')

@section('pendaftaran_kelas','active')

@section('page-name-header','Create Notifikasi Peringatan')

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
                        <input name="nama_kelas" type="text" id="exampleForm1" class="form-control" placeholder="Masukkan Nama Kelas">

                        <label>HSK</label>
                        <select class="selectpicker w-100" name="hsk">
                            <option value="">Pilih HSK</option>
                            <option value="pemula" @if(old('status') == 'pemula') selected @endif>pemula</option>
                            <option value="hsk 1" @if(old('status') == 'hsk 1') selected @endif>HSK 1</option>
                            <option value="hsk 2" @if(old('status') == 'hsk 2') selected @endif>HSK 2</option>
                            <option value="hsk 3" @if(old('status') == 'hsk 3') selected @endif>HSK 3</option>
                            <option value="hsk 4" @if(old('status') == 'hsk 4') selected @endif>HSK 4</option>
                            <option value="hsk 5" @if(old('status') == 'hsk 5') selected @endif>HSK 5</option>
                            <option value="hsk 6" @if(old('status') == 'hsk 6') selected @endif>HSK 6</option>
                        </select>
                        @error('status') <p class="text-danger m-0 p-0"><small>{{ $errors->first('status') }}</small></p> @enderror

                        <label class="mt-2" for="exampleForm2">TANGGAL MULAI KELAS</label>
                        <input name="tanggal_mulai" type="date" id="exampleForm2" class="form-control">
                        
                        <label class="mt-2" for="exampleForm3">TANGGAL SELESAI KELAS</label>
                        <input name="tanggal_selesai" type="date" id="exampleForm3" class="form-control">

                        <label class="mt-2">KELAS BERBAYAR</label>
                        <div class="custom-control custom-checkbox text-center" onchange="showInputHarga()">
                            <input name="isberbayar" type="checkbox" class="custom-control-input" id="defaultUnchecked">
                            <label class="custom-control-label" for="defaultUnchecked">CENTANG APABILA IYA</label>
                        </div>
                        
                        <div id="input_harga" class="d-none">
                            <label class="mt-2">HARGA</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                <div class="input-group-text">Rp. </div>
                                </div>
                                <input name="harga" id="money" type="number" class="form-control" id="inlineFormInputGroup" placeholder="Harga Pendaftaran Kelas">
                            </div>
                        </div>

                        <label class="mt-2" for="exampleForm3">KUOTA</label>
                        <input name="kuota" type="number" id="exampleForm3" class="form-control">

                        <label class="mt-2">IMAGE KELAS</label>
                        <div class="custom-file">
                            <input id="image_kelas" type="file" class="custom-file-input" id="validatedCustomFile" required>
                            <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                        </div>

                        <label>Status</label>
                        <select class="selectpicker w-100" name="status">
                            <option value="">Pilih Status Pendaftaran</option>
                            <option value="aktif" @if(old('status') == 'aktif') selected @endif>BUKA</option>
                            <option value="tidak" @if(old('status') == 'tidak') selected @endif>TUTUP</option>
                        </select>
                        @error('status') <p class="text-danger m-0 p-0"><small>{{ $errors->first('status') }}</small></p> @enderror
                        
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="mt-2">Pengajar</label>
                        <select class="selectpicker w-100" name="id_pengajar">
                            <option value="">Pilih Pengajar</option>
                            @if(isset($pengajars))
                                @if($pengajars->count() > 0)
                                    @foreach($pengajars as $index => $pengajar)
                                        <option value="{{ $pengajar->id }}" @if(old('status') == 'aktif') selected @endif>{{ $pengajar->nama_pengajar }}</option>
                                    @endforeach
                                @endif
                            @endif
                        </select>

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
                                        <select class="custom-select w-100" name="jadwal[]['day']">
                                            <option value="">Pilih Hari</option>
                                            <option value="sunday">SUNDAY</option>
                                            <option value="monday">MONDAY</option>
                                            <option value="thursday">THURSDAY</option>
                                            <option value="wednesday">WEDNESDAY</option>
                                            <option value="tuesday">TUESDAY</option>
                                            <option value="friday">FRIDAY</option>
                                            <option value="saturday">SATURDAY</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-12">
                                        <label class="d-block d-lg-none m-2">WAKTU MULAI</label>
                                        <input type="time" class="form-control" name="jadwal[]['waktu_mulai']">
                                    </div>

                                    <div class="col-lg-4 col-12">
                                        <label class="d-block d-lg-none m-2">WAKTU SELESAI</label>
                                        <input type="time" class="form-control" name="jadwal[]['waktu_selesai']">
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
        $('#summernote').summernote({
            height: 300,
        });
        $('#summernote').summernote("code",'<h1 style="text-align: center; "><b>PENGUMUMAN TCI UDAYANA</b></h1><p style="text-align: justify;">Pengumuman anda di sini....</p>');
        $("#money").maskMoney({
            precision:0,
            thousands:".",
            decimal:",",
            allowEmpty:true,
        });        
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