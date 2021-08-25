@extends('admin.admin-layout.admin-layout')

@section('pendaftaran_kelas','active')

@section('page-name-header','Detail Pendaftaran Kelas')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.pendaftarankelas') }}">Pendaftaran Kelas</a></li>
<li class="breadcrumb-item active">Detail Pendaftaran Kelas</li>
@endsection

@section('content')
<div class="row">
    <a href="" class="btn btn-sm btn-info mx-1"><i class="far fa-edit"></i> EDIT PENDAFTARAN</a>
    <a href="" class="btn btn-sm btn-primary mx-1"><i class="fas fa-school"></i> LIHAT KELAS</a>
    <a href="" class="btn btn-sm btn-danger mx-1"><i class="far fa-trash-alt"></i> DELETE PENDAFTARAN</a>
    <a href="" class="btn btn-sm btn-warning mx-1"><i class="fas fa-bullhorn"></i> PENGUMUMAN PENDAFTARAN</a>
    
    <div class="col-12 jumbotron mt-3 p-2">
        <div class="container-fluid p-2">
            <div class="row">
                <div class="col-12 text-center text-lg-left">
                    <h5>DETAIL PENDAFTARAN KELAS</h5>
                </div>
                <div class="col-12 col-lg-6">
                    <label for="exampleForm1">Nama Pendaftaran</label>
                    <input type="text" value="{{ $pendaftaran->nama_pendaftaran }}" id="exampleForm1" class="form-control @error('nama_pendaftaran') border border-danger @enderror" placeholder="Masukkan nama pendaftaran" readonly>

                    <label for="exampleForm2">Keterangan</label>
                    <input type="text" value="{{ $pendaftaran->keterangan }}" id="exampleForm2" class="form-control" placeholder="Masukkan nama pendaftaran" readonly>
                </div>

                <div class="col-12 col-lg-6">
                    <label for="exampleForm3">Tanggal Mulai Pendaftaran</label>
                    <input type="datetime-local" value="{{ date('Y-m-d\TH:i', strtotime($pendaftaran->tanggal_mulai_pendaftaran)) }}" id="exampleForm3" class="form-control" readonly>
                    
                    <label for="exampleForm4">Tanggal Selesai Pendaftaran</label>
                    <input type="datetime-local" value="{{ date('Y-m-d\TH:i', strtotime($pendaftaran->tanggal_selesai_pendaftaran)) }}" id="exampleForm4" class="form-control" readonly>
                </div>

                <div class="col-12">
                    <label for="exampleForm2">Status</label>
                    <select class="selectpicker w-100" disabled>
                        <option value="">Pilih Status Pendaftaran</option>
                        <option value="aktif" @if($pendaftaran->status == 'aktif') selected @endif>AKTIF</option>
                        <option value="tidak" @if($pendaftaran->status == 'tidak') selected @endif>TIDAK</option>
                    </select>
                </div>
            </div>
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