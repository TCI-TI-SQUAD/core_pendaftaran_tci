@extends('admin.admin-layout.admin-layout')

@section('pendaftaran_kelas','active')

@section('page-name-header','Pendaftaran Kelas')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item active">Pendaftaran Kelas</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <a href="{{ route('admin.trashed.pendaftarankelas') }}" class="btn btn-sm btn-info"><i class="far fa-edit"></i> LIHAT TRASHED PENDAFTARAN</a>
        <a href="{{ route('admin.index.archived.pendaftarankelas') }}" class="btn btn-sm btn-warning"><i class="far fa-edit"></i> LIHAT ARSIP PENDAFTARAN</a>
        <a href="{{ route('admin.create.pendaftarankelas') }}" class="btn btn-sm btn-success"><i class="far fa-edit"></i> BUAT PENDAFTARAN BARU</a>
    </div>
    <div class="col-12 jumbotron p-2 shadow">
        <table class="table responsive wrap" width="100%" id="table_id">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Nama Pendaftaran</th>
            <th scope="col">Tanggal Mulai</th>
            <th scope="col">Tanggal Selesai</th>
            <th scope="col">Banyak Kelas</th>
            <th scope="col">Status</th>
            <th scope="col">Keterangan</th>
            <th scope="col">Created At</th>
            <th scope="col">Updated At</th>
            <th scope="col">Aksi</th>
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
    let table;
    $(document).ready( function () {

        table = $('#table_id').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'pageLength',
                {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: ':visible',
                    search : 'applied',
                    modifer: {
                        page: 'all',
                    }
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible',
                    search : 'applied',
                    modifer: {
                        page: 'all',
                    }
                },
                action: function(e, dt, button, config) {
                                     responsiveToggle(dt);
                                     $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, button, config);
                                     responsiveToggle(dt);
                                 }
            },
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: ':visible',
                    search : 'applied',
                    modifer: {
                        page: 'all',
                    }
                },
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible',
                    search : 'applied',
                    modifer: {
                        page: 'all',
                    }
                },
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            }
            ],
            "ajax": {
                "url": "{{ Route('admin.ajax.pendaftarandata') }}",
                "type": "POST",
                "data":{
                    "_token": "{{ csrf_token() }}"
                }
            },
            "columns": [
                { "data": "number" },
                { "data": "nama_pendaftaran" },
                { "data": "tanggal_mulai_pendaftaran"},
                { "data": "tanggal_selesai_pendaftaran" },
                { "data": "kelas_count","visible" :false },
                { "data": "status" },
                { "data": "keterangan","visible" :false },
                { "data": "created_at","visible" :false },
                { "data": "updated_at","visible" :false },
                {
                    data: "id",title:"Aksi",
                    render: function ( data, type, row, meta ) {
                        return '<a href="{{ route("admin.detail.pendaftarankelas") }}/'+data+'" class="btn btn-sm btn-primary"><i class="far fa-eye"></i></a><a href="{{ route("admin.edit.pendaftarankelas") }}/'+data+'" class="btn text-white btn-sm btn-info"><i class="far fa-edit"></i></a><button class="btn text-white btn-sm btn-warning" onclick="archivePendaftaranKelas('+data+')"><i class="fas fa-file-archive"></i></button><a class="btn text-white btn-sm btn-danger" onclick="deletePendaftaranKelas('+data+')"><i class="far fa-trash-alt"></i></a> <form id="form-archived-'+data+'" method="POST" action="{{ route("admin.archived.pendaftarankelas") }}"> @csrf @method("PUT") <input type="hidden" name="id" value="'+data+'"></form><form id="delete-pendaftaran-kelas-'+data+'" action="{{ route("admin.delete.pendaftarankelas") }}" method="POST" style=" display: none;"> @csrf @method("DELETE") <input name="id" value="'+data+'" type="hidden"></form>';
                    }
                }
            ],
        });
    } );

    function detailData(index){
        try{
            let data = table.row(index).data();

            Swal.fire({
                title: 'DETAIL PENGUMUMAN',
                html: 
                '<div style="border-top:2px solid purple;border-bottom:2px solid purple;max-height:70vh;overflow:auto;">'+
                data.pengumuman+
                '</div>'
            })
        }catch(err){
            Swal.fire({
                title: 'OPPSS Something Wrong',
                html: 
                '<div style="border-top:2px solid purple;border-bottom:2px solid purple;">'+
                "OPPS... SOMETHING WRONG"+
                '</div>'
            })
        }
        
    }

    function deletePendaftaranKelas(index){
            Swal.fire({
            title: 'Delete Pendaftaran Ini ?',
            html: 
            '<p>Berikut merupakan effect apabila admin menghapus Pendaftaran Kelas</p>'+
            '<ul class="text-left">'+
            '<li>User yang  telah mendaftar dan juga user yang belum mendaftar sama-sama tidak akan mampu mengakses pendaftaran beserta kelas yang ada di dalamnya kembali</li>'+
            '<li>Pendaftaran yang telah dihapus masih dapat dipulihkan dari halaman <span class="text-info">TRASHED PENDAFTARAN</span> </li>'+
            '<li>Pendaftaran yang dipulihkan maka akan masih menyimpan data sama seperti sebelum dihapus</li>'+
            '<li>Apabila admin ingin mengarsipkan Pendaftaran maka pilih opsi <span class="text-info">PENGARSIPAN</span> </li>'+
            '<li>Semua kelas yang berada di dalam Pendaftaran Ini tidak akan dapat diakses</li>'+
            '</ul>'
            ,
            icon:'warning',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Delete`,
            denyButtonText: `Batal`,
            }).then((result) => {
                
            if (result.isConfirmed) {
                $('#delete-pendaftaran-kelas-'+index).submit();
            } else if (result.isDenied) {

            }
            })
        }
    
        function archivePendaftaranKelas(index){
            Swal.fire({
            title: 'Archive Pendaftaran Kelas Ini ?',
            html: 
            '<p>Berikut merupakan effect apabila admin melakukan Archive Pendaftaran Kelas</p>'+
            '<ul class="text-left">'+
            '<li>Archive dapat digunakan untuk menyimpan Pendaftaran yang dirasa sudah tidak diperlukan untuk tampil di halaman index Pendaftaran </li>'+
            '<li>Tidak akan ada yang terjadi apabila anda melakukan Archive sebuah pendaftaran, Pendaftaran hanya pindah ke halaman Archive tanpa ada efek pada sisi User </li>'+
            '</ul>'
            ,
            icon:'warning',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Archive`,
            denyButtonText: `Batal`,
            }).then((result) => {
                
            if (result.isConfirmed) {
                $('#form-archived-'+index).submit();
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