@extends('admin.admin-layout.admin-layout')

@section('pendaftaran_kelas','active')

@section('page-name-header','Create Pendaftaran Kelas')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.pendaftarankelas') }}">Pendaftaran Kelas</a></li>
<li class="breadcrumb-item active">Create Pendaftaran Kelas</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="container-fluid jumbotron p-2">
            <form action="{{ route('admin.post.create.pendaftarankelas') }}" method="POST" onsubmit="myButton.disabled = true; return true;" id="pendaftaran-form">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-12 text-center text-lg-left">
                        <h5>FORM CREATE PENDAFTARAN KELAS</h5>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="exampleForm1">Nama Pendaftaran</label>
                        <input name="nama_pendaftaran" type="text" id="exampleForm1" class="form-control @error('nama_pendaftaran') border border-danger @enderror" placeholder="Masukkan nama pendaftaran">
                        @error('nama_pendaftaran') <p class="text-danger m-0 p-0"><small>{{ $errors->first('nama_pendaftaran') }}</small></p> @enderror

                        <label for="exampleForm2">Keterangan</label>
                        <input name="keterangan" type="text" id="exampleForm2" class="form-control" placeholder="Masukkan nama pendaftaran">
                    </div>

                    <div class="col-12 col-lg-6">
                        <label for="exampleForm3">Tanggal Mulai Pendaftaran</label>
                        <input name="tanggal_mulai_pendaftaran" type="datetime-local" id="exampleForm3" class="form-control">
                        
                        <label for="exampleForm4">Tanggal Selesai Pendaftaran</label>
                        <input name="tanggal_selesai_pendaftaran" type="datetime-local" id="exampleForm4" class="form-control">
                    </div>

                    <div class="col-12">
                        <label for="exampleForm2">Status</label>
                        <select class="selectpicker w-100" name="status">
                            <option value="" selected>Pilih Status Pendaftaran</option>
                            <option value="aktif">AKTIF</option>
                            <option value="tidak">TIDAK</option>
                        </select>
                    </div>

                    <div class="col-12 mt-3">
                        <button name="myButton" type="button" class="btn btn-block btn-primary" onclick="peringatanPendaftaran()">SUBMIT</button>
                        <a href="{{ route('admin.pendaftarankelas') }}" type="submit" class="btn btn-block btn-danger">BACK</a>
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
<script>

    function peringatanPendaftaran(){
            Swal.fire({
            title: 'Yakin Membuat Pendaftaran Baru ?',
            html: 
            '<p>Berikut merupakan effect apabila admin membuat pendaftaran baru</p>'+
            '<ul class="text-left">'+
            '<li>Pendaftaran yang berstatus aktif akan terlihat pada sisi user</li>'+
            '<li>Pendaftaran yang baru dibuat tidak langsung berisikan kelas melainkan admin harus menginputkan kelas setelah membuat pendaftaran baru</li>'+
            '<li>Pendaftaran dapat diakses dalam jangka waktu tanggal mulai pendaftaran hingga tanggal selesai pendaftaran</li>'+
            '<li>Jadi apabila tanggal saat ini berada diluar range tanggal mulai dan selesai maka pendaftaran tidak dapat dilakukan oleh user</li>'+
            '</ul>'
            ,
            icon:'warning',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Submit`,
            denyButtonText: `Batal`,
            }).then((result) => {

            if (result.isConfirmed) {
                $('#pendaftaran-form').submit();
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