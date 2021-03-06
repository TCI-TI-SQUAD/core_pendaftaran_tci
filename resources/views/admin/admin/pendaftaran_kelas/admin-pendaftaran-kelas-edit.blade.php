@extends('admin.admin-layout.admin-layout')

@section('pendaftaran_kelas','active')

@section('page-name-header','Create Pendaftaran Kelas')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.pendaftarankelas') }}">Pendaftaran Kelas</a></li>
<li class="breadcrumb-item active">Edit Pendaftaran Kelas</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="container-fluid jumbotron p-2">
            <form action="{{ route('admin.store.edit.pendaftarankelas') }}" method="POST" onsubmit="myButton.disabled = true; return true;" id="pendaftaran-form">
                <input type="hidden" value="{{ $pendaftaran->id }}" name="id">
                @csrf
                @method('PUT')
                <div class="row">
                    
                    <div class="col-12 text-center text-lg-left">
                        <h5>FORM CREATE PENDAFTARAN KELAS</h5>
                    </div>

                    <div class="col-12 col-lg-6">
                        <label for="exampleForm1">Nama Pendaftaran</label>
                        <input name="nama_pendaftaran" value="{{ $pendaftaran->nama_pendaftaran }}" type="text" id="exampleForm1" class="form-control @error('nama_pendaftaran') border border-danger @enderror" placeholder="Masukkan nama pendaftaran">
                        @error('nama_pendaftaran') <p class="text-danger m-0 p-0"><small>{{ $errors->first('nama_pendaftaran') }}</small></p> @enderror

                        <label for="exampleForm2">Keterangan</label>
                        <input name="keterangan" value="{{ $pendaftaran->keterangan }}" type="text" id="exampleForm2" class="form-control" placeholder="Masukkan keterangan pendaftaran">
                        @error('keterangan') <p class="text-danger m-0 p-0"><small>{{ $errors->first('keterangan') }}</small></p> @enderror
                    </div>

                    <div class="col-12 col-lg-6">
                        <label for="exampleForm3">Tanggal Mulai Pendaftaran</label>
                        <input name="tanggal_mulai_pendaftaran" value="{{ date('Y-m-d\TH:i', strtotime($pendaftaran->tanggal_mulai_pendaftaran)) }}" type="datetime-local" id="exampleForm3" class="form-control">
                        @error('tanggal_mulai_pendaftaran') <p class="text-danger m-0 p-0"><small>{{ $errors->first('tanggal_mulai_pendaftaran') }}</small></p> @enderror
                        
                        <label for="exampleForm4">Tanggal Selesai Pendaftaran</label>
                        <input name="tanggal_selesai_pendaftaran" value="{{ date('Y-m-d\TH:i', strtotime($pendaftaran->tanggal_selesai_pendaftaran)) }}" type="datetime-local" id="exampleForm4" class="form-control">
                        @error('tanggal_selesai_pendaftaran') <p class="text-danger m-0 p-0"><small>{{ $errors->first('tanggal_selesai_pendaftaran') }}</small></p> @enderror
                    </div>

                    <div class="col-12">
                        <label for="exampleForm2">Status</label>
                        <select class="selectpicker w-100" name="status">
                            <option value="">Pilih Status Pendaftaran</option>
                            <option value="aktif" @if($pendaftaran->status == 'aktif') selected @endif>AKTIF</option>
                            <option value="tidak" @if($pendaftaran->status == 'tidak') selected @endif>TIDAK</option>
                        </select>
                        @error('status') <p class="text-danger m-0 p-0"><small>{{ $errors->first('status') }}</small></p> @enderror
                    </div>

                    <div class="col-12 mt-3">
                        <button name="myButton" type="button" class="btn btn-block btn-primary" onclick="peringatanUpdatePendaftaran()">SUBMIT</button>
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

    function peringatanUpdatePendaftaran(){
            Swal.fire({
            title: 'Yakin Edit Pendaftaran ?',
            html:
            '<div style="max-height:70vh;overflow:auto;">'+
            '<p>Berikut merupakan effect apabila admin melakuakn update pendaftaran baru</p>'+
            '<ul class="text-left">'+
            '<li>Pendaftaran yang berstatus aktif akan terlihat pada sisi user</li>'+
            '<li>Mengubah nama, tanggal mulai dan selesai atau keterangan <span class="text-danger font-weight-bold">TIDAK AKAN MENGUBAH</span> Invoice / Transaksi yang telah dilakukan oleh user jadi mohon bijak dalam melakukan update data Pendaftaran Kelas</li>'+
            '<li>Tanggal mulai harus lebih <span class="text-info">AWAL</span> dari pada tanggal selesai </li>'+
            '<li>Input tanggal mulai <span class="text-info">SEBELUM HARI INI</span> ini diizinkan</li>'+
            '<li>Pendaftaran dapat diakses dalam jangka waktu tanggal mulai pendaftaran hingga tanggal selesai pendaftaran</li>'+
            '<li>Jadi apabila tanggal saat ini berada diluar range tanggal mulai dan selesai maka pendaftaran tidak dapat dilakukan oleh user walaupun status pendaftaran aktif</li>'+
            '<li>Perhatikan dengan baik apabila melakukan update pada tanggal</li>'+
            '</ul>'+
            '</div>'
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