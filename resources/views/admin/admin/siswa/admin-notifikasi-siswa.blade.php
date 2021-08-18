@extends('admin.admin-layout.admin-layout')

@section('siswa','active')

@section('page-name-header','Notifikasi Peringatan')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.siswa') }}">Siswa</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.detail.siswa',[$user->id]) }}">Detail Siswa</a></li>
<li class="breadcrumb-item active">Notifikasi Peringatan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <a href="{{ route('admin.notifikasi.siswa.create',[$user->id]) }}" class="btn btn-sm btn-success"><i class="far fa-edit"></i> NOTIFIKASI BARU</a>
    </div>
    <div class="col-12 mb-3">
        <table>
            <tr>
                <th>Nama Siswa :</th>
                <td>{{ $user->name }}</td>
            </tr>
        </table>
    </div>
    <div class="col-12 jumbotron p-2 shadow">
        <table class="table responsive nowrap" width="100%" id="table_id">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Judul Notifikasi</th>
            <th scope="col">Pesan</th>
            <th scope="col">tanggal</th>
            <th scope="col">icon</th>
            <th scope="col">warna</th>
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
                "url": "{{ Route('admin.ajax.notifikasi.siswa') }}",
                "type": "POST",
                "data":{
                    "_token": "{{ csrf_token() }}",
                    "id" : "{{ $user->id }}"
                }
            },
            "columns": [
                { "data": "number" },
                { "data": "title" },
                { "data": "message" },
                { "data": "datetime" },
                { "data": "icon" },
                {
                    data: "color",title:"warna",
                    render: function ( data, type, row ) {
                        return '<div class="rounded text-center '+data+' ">'+data+'</div>';
                    }
                },
                {
                    data: "id",title:"Aksi",
                    render: function ( data, type, row ) {
                        return '<a href="{{ route("admin.detail.siswa") }}/'+data+'" class="btn btn-sm btn-primary"><i class="far fa-eye"></i></a><a href="{{ route("admin.edit.siswa") }}/'+data+'" class="btn text-white btn-sm btn-info"><i class="far fa-edit"></i></a><a class="btn text-white btn-sm btn-danger" onclick="deleteNotifikasi('+data+')"><i class="far fa-trash-alt"></i></a> <form id="delete-siswa-'+data+'" action="{{ route("admin.notifikasi.siswa.delete") }}" method="POST" style=" display: none;"> @csrf @method("DELETE") <input name="id" value="'+data+'" type="hidden"></form>';
                    }
                }
            ]
        });
    } );

    function deleteNotifikasi(index){
            Swal.fire({
            title: 'Hapus Notifikasi Siswa ini ?',
            html: 
            '<p>Berikut merupakan effect apabila admin menghapus notifikasi</p>'+
            '<ul class="text-left">'+
            '<li>User tidak akan bisa melihat notifikasi yang telah dihapus</li>'+
            '<li>Tidak seperti data krusial lainnya, notifikasi apabila dihapus maka tidak akan bisa <span class="text-danger">DIPULIHKAN</span> </li>'+
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