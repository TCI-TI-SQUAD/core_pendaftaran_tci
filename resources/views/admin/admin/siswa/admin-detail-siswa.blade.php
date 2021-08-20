@extends('admin.admin-layout.admin-layout')

@section('siswa','active')

@section('page-name-header','Siswa')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item"> <a href="{{ route('admin.siswa') }}">Siswa</a></li>
<li class="breadcrumb-item active">Detail Siswa</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <a href="{{ route('admin.edit.siswa').'/'.$user->id }}" class="btn btn-sm btn-info"><i class="far fa-edit"></i> EDIT SISWA</a>
        <a href="{{ route('admin.notifikasi.siswa.index',[$user->id]) }}" class="btn btn-sm btn-warning"><i class="far fa-eye"></i> NOTIFIKASI PERINGATAN</a>  
        <button onclick="deleteSiswa({{ $user->id }})" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i> DELETE SISWA</button>
        <form action="{{ route('admin.delete.siswa') }}" method="POST" style="display:none;" id="delete-siswa-{{ $user->id }}">
            @csrf
            @method('delete')
            <input type="hidden" name="id" value="{{ $user->id }}">
        </form>
        <a href="{{ route('admin.email.siswa.index',[$user->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-envelope-square"></i> KIRIM E-MAIL</a>
        <a target="__blank" class="btn btn-sm btn-info" href="https://wa.me/{{ $user->phone_number }}?text=Halo, saya admin TCI, maksud saya menghubungi saudara adalah untuk "><i class="fab fa-whatsapp"></i> HUBUNGI VIA WA</a>
        <a target="__blank" class="btn btn-sm btn-success" href="http://line.me/ti/p/~{{ $user->line }}"><i class="fab fa-whatsapp"></i> LIHAT LINE ID</a>
    </div>
    <div class="col-12 jumbotron shadow">
        <div class="container">
            <div class="row">
                @if(isset($user))
                    <div class="col-12 col-lg-3 text-center">
                        @if(isset($user->user_profile_pict))
                            <img src="{{ asset('storage/image_users').'/'.$user->user_profile_pict }}" alt="" style="width:200px;height:200px;object-fit:cover;" class="img-thumbnail rounded-circle">
                        @else
                            <img src="{{ asset('storage/image_users/default.jpg') }}" alt="" style="width:200px;height:200px;object-fit:cover;" class="img-thumbnail rounded-circle">
                        @endif
                    </div>
                    
                    <div class="col-12 col-lg-9">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <label >Name</label>
                                    <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                                    <label class="mt-2">Username</label>
                                    <input type="text" class="form-control" value="{{ $user->username }}" readonly>
                                    <label class="mt-2">Nomor Pelajar TCi</label>
                                    <input type="text" class="form-control" value="{{ $user->nomor_pelajar_tci }}" readonly>
                                    <label class="mt-2">Status Instansi Saat ini</label>
                                    <input type="text" class="form-control" value="{{ $user->getInstansiName() }}" readonly>
                                    <label class="mt-2">Email</label>
                                    <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                                    <label class="mt-2">Phone Number</label>
                                    <input type="text" class="form-control" value="{{ $user->phone_number }}" readonly>
                                    <label class="mt-2">Line</label>
                                    <input type="text" class="form-control" value="{{ $user->line }}" readonly>
                                    <label class="mt-2">WA</label>
                                    <input type="text" class="form-control" value="{{ $user->wa }}" readonly>
                                    <label class="mt-2">Alamat</label>
                                    <input type="text" class="form-control" value="{{ $user->alamat }}" readonly>
                                    <label class="mt-2">Kartu Identitas [{{ strtoupper($user->jenis_kartu_identitas) }}]</label>
                                    <a target="__blank" href="{{ asset('storage/kartu_identitas').'/'.$user->kartu_identitas }}" class="btn btn-block btn-info">LIHAT KARTU IDENTITAS</a>
                                    <label class="mt-2">Hak Akses</label>
                                    <input type="text" class="form-control" value="{{ strtoupper($user->hak_akses) }}" readonly>
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

    });

    function deleteSiswa(index){
        Swal.fire({
        title: 'Hapus siswa ini ?',
        html: 
        '<p>Berikut merupakan effect apabila admin menghapus user</p>'+
        '<ul class="text-left">'+
        '<li>User tidak akan bisa login</li>'+
        '<li>User tidak akan terlihat di semua kelas yang telah diikuti</li>'+
        '<li>Jumlah anggota kelas akan berkurang</li>'+
        '<li>User masih dapat dipulihkan dengan halaman <span class="text-info">TRASHED</span></li>'+
        '<li>User akan hilang dari semua report</li>'+
        '<li>Saat dipulihkan user akan kembali seperti semula</li>'+
        '</ul>'
        ,
        icon:'warning',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: `Hapus`,
        denyButtonText: `Batal`,
        }).then((result) => {
            
        if (result.isConfirmed) {
            $('#delete-siswa-'+index).submit();
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