@extends('admin.admin-layout.admin-layout')

@section('siswa','active')

@section('page-name-header','Create Notifikasi Peringatan')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.siswa') }}">Siswa</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.detail.siswa',[$user->id]) }}">Detail Siswa</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.notifikasi.siswa.index',[$user->id]) }}">Notifikasi Peringatan</a></li>
<li class="breadcrumb-item active">Create Notifikasi Peringatan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <table>
            <tr>
                <th>
                    Nama Siswa :
                </th>
                <td>
                    {{ $user->name }}
                </td>
            </tr>
        </table>
    </div>

    <div class="col-12 jumbotron shadow p-2 mt-2">
        <div class="container-fluid">
            <form action="{{ route('admin.notifikasi.siswa.store') }}" method="POST" onsubmit="myButton.disabled = true; return true;">
                @csrf
                @method('POST')
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="row">
                    <div class="col-12 text-center text-lg-left">
                        <h5>FORM CREATE NOTIFIKASI PERINGATAN</h5>
                    </div>

                    <div class="col-12 col-lg-6">
                            <div class="row">
                                <div class="col-12">
                                    <!-- Default input -->
                                    <label for="exampleForm1">JUDUL</label>
                                    <input name="title" type="text" id="exampleForm1" class="form-control" placeholder="Judul Notifikasi">
                                </div>

                                <div class="col-12">
                                    <label for="exampleForm2">WARNA</label>
                                    <select name="color" class="selectpicker w-100">
                                        <option value="bg-info">BIRU INFO</option>
                                        <option value="bg-primary">BIRU PEKAT</option>
                                        <option value="bg-danger">MERAH PEKAT</option>
                                        <option value="bg-warning">KUNING PERINGATAN</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label>ICON</label>
                                    <select name="icon" class="selectpicker w-100">
                                        <option data-icon="fa fa-exclamation-triangle" value="fa-exclamation-triangle" selected>fa-exclamation-triangle</option>
                                        @if(isset($icons))
                                            @foreach($icons as $icon)
                                                <option data-icon="fa {{ $icon }}" value="1">{{ $icon }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>
                            </div>
                    </div>

                    <div class="col-12 col-lg-6 mt-3 mt-lg-0">
                        <label for="summernote">NOTIFIKASI</label>
                        <textarea id="summernote" name="message"></textarea>
                    </div>

                    <div class="col-12 text-center">
                        <button class="btn btn-md w-100 d-lg-none d-inline-block btn-primary" type="submit" name="myButton">KIRIM</button>
                        <a href="{{ route('admin.notifikasi.siswa.index',[$user->id]) }}" class="btn btn-md w-25 d-lg-inline-block d-none btn-danger">BATAL</a>
                        <a href="{{ route('admin.notifikasi.siswa.index',[$user->id]) }}" class="btn btn-md w-100 mt-3 d-lg-none d-inline-block btn-danger">BATAL</a>
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
      
    });

    function updateIcon(select){
        $("#current_icon").html("<i class="+select.value+"></i>")
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