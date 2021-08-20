@extends('admin.admin-layout.admin-layout')

@section('siswa','active')

@section('page-name-header','Create E-Mail Siswa')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.siswa') }}">Siswa</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.detail.siswa',[$user->id]) }}">Detail Siswa</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.email.siswa.index',[$user->id]) }}">E-Mail Siswa</a></li>
<li class="breadcrumb-item active">Create E-Mail Siswa</li>
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
            <form action="{{ route('admin.email.siswa.store') }}" method="POST" onsubmit="myButton.disabled = true; return true;">
                @csrf
                @method('POST')
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="row">
                    <div class="col-12 text-center text-lg-left">
                        <h5>FORM CREATE E-MAIL SISWA</h5>
                    </div>

                    <div class="col-12 col-lg-6">
                            <div class="row">
                                <div class="col-12">
                                    <!-- Default input -->
                                    <label for="exampleForm1">JUDUL</label>
                                    <input name="title" type="text" id="exampleForm1" class="form-control" placeholder="Judul E-Mail" minlength="3" maxlength="20" required>
                                </div>

                                <div class="col-12">
                                    <!-- Default input -->
                                    <label for="exampleForm1">SUBJECT</label>
                                    <input name="subject" type="text" id="exampleForm1" class="form-control" placeholder="Subject E-Mail" minlength="3" maxlength="20" required>
                                </div>
                            </div>
                    </div>

                    <div class="col-12 col-lg-6 mt-3 mt-lg-0">
                        <label for="summernote">E-MAIL</label>
                        <textarea id="summernote" name="message" required></textarea>
                    </div>

                    <div class="col-12 text-center">
                        <button class="btn btn-md w-100 d-lg-none d-inline-block btn-primary" type="submit" name="myButton">KIRIM</button>
                        <a href="{{ route('admin.email.siswa.index',[$user->id]) }}" class="btn btn-md w-25 d-lg-inline-block d-none btn-danger">BATAL</a>
                        <a href="{{ route('admin.email.siswa.index',[$user->id]) }}" class="btn btn-md w-100 mt-3 d-lg-none d-inline-block btn-danger">BATAL</a>
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
@push('js')
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 300,
        });
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