@extends('admin.admin-layout.admin-layout')

@section('pengumuman_sistem','active')

@section('page-name-header','Create Notifikasi Peringatan')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.pendaftarankelas') }}">Pendaftaran Kelas</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.detail.pendaftarankelas',[$pendaftaran->id]) }}">Detail Pendaftaran Kelas</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.index.pengumuman.pendaftarankelas',[$pendaftaran->id]) }}">Pengumuman Pendaftaran Kelas</a></li>
<li class="breadcrumb-item active">Create Pengumuman Pendaftaran Kelas</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 jumbotron shadow p-2 mt-2">
        <div class="container-fluid">
            <form action="{{ route('admin.post.create.pengumuman.pendaftarankelas') }}" method="POST" onsubmit="myButton.disabled = true; return true;">
                <input type="hidden" value="{{ $pendaftaran->id }}" name="id">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-12 text-center text-lg-left">
                        <h5>FORM CREATE PENGUMUMAN PENDAFTARAN KELAS</h5>
                    </div>

                    <div class="col-12 col-lg-8 m-auto">
                        <label for="summernote">PENGUMUMAN</label>
                        <textarea id="summernote" name="pengumuman" required></textarea>
                    </div>

                    <div class="col-12 text-center">
                        <button class="btn btn-md w-100 d-lg-none d-inline-block btn-primary" type="submit" name="myButton">KIRIM</button>
                        <a href="{{ route('admin.index.pengumuman.pendaftarankelas',[$pendaftaran->id]) }}" class="btn btn-md w-25 d-lg-inline-block d-none btn-danger">BATAL</a>
                        <a href="{{ route('admin.index.pengumuman.pendaftarankelas',[$pendaftaran->id]) }}" class="btn btn-md w-100 mt-3 d-lg-none d-inline-block btn-danger">BATAL</a>
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
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 300,
        });
        $('#summernote').summernote("code",'<h1 style="text-align: center; "><b>PENGUMUMAN TCI UDAYANA</b></h1><p style="text-align: justify;">Pengumuman anda di sini....</p>');
        
    });
    
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