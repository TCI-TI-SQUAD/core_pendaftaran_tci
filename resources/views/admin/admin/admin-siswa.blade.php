@extends('admin.admin-layout.admin-layout')

@section('siswa','active')

@section('page-name-header','Siswa')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item active">Siswa</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <a href="" class="btn btn-sm btn-info"><i class="far fa-trash-alt"></i> LIHAT TRASHED SISWA</a>
        <a href="" class="btn btn-sm btn-success"><i class="far fa-edit"></i> BUAT SISWA BARU</a>
    </div>
    <div class="col-12 jumbotron p-2 shadow">
        <table class="table responsive nowrap" width="100%" id="table_id">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Nama</th>
            <th scope="col">HSK</th>
            <th scope="col">Nomor Pelajar TCI</th>
            <th scope="col">email</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        </table>
    </div>

</div>
@endsection

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins\datatables-bs4\css\dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins\datatables-responsive\css\responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins\datatables-buttons\css\buttons.bootstrap4.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
    $(document).ready( function () {
        $('#table_id').DataTable({
            responsive: true,
            "ajax": {
                "url": "{{ Route('admin.ajax.siswa') }}",
                "type": "POST",
                "data":{
                    "_token": "{{ csrf_token() }}"
                }
            },
            "columns": [
                { "data": "number" },
                { "data": "name" },
                { "data": "hsk" },
                { "data": "nomor_pelajar_tci" },
                { "data": "email" },
                {
                    data: "id",title:"Aksi",
                    render: function ( data, type, row ) {
                        return '<a href="{{ route("admin.detail.siswa") }}/'+data+'" class="btn btn-sm btn-primary"><i class="far fa-eye"></i></a><a href="{{ route("admin.edit.siswa") }}/'+data+'" class="btn text-white btn-sm btn-info"><i class="far fa-edit"></i></a><a class="btn text-white btn-sm btn-danger" onclick="deleteSiswa('+data+')"><i class="far fa-trash-alt"></i></a> <form id="delete-siswa-'+data+'" action="{{ route("admin.delete.siswa") }}" method="POST" style=" display: none;"> @csrf @method("DELETE") <input name="id" value="'+data+'" type="hidden"></form>';
                    }
                }
            ]
        });
    } );

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