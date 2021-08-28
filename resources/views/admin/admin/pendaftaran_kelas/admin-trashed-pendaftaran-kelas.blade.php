@extends('admin.admin-layout.admin-layout')

@section('pendaftaran_kelas','active')

@section('page-name-header','Trashed Pendaftaran Kelas')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.pendaftarankelas') }}">Pendaftaran Kelas</a></li>
<li class="breadcrumb-item active">Trashed Pendaftaran Kelas</li>
@endsection

@section('content')
<div class="row">
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
                "url": "{{ Route('admin.ajax.trashed.pendaftarankelas') }}",
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
                        return '<button class="btn btn-sm btn-info" onclick="restorePendaftaranKelas('+data+')"><i class="fas fa-trash-restore"></i></button><form id="form-restore-'+data+'" method="POST" action="{{ route("admin.restore.pendaftarankelas") }}"> @csrf @method("PUT") <input type="hidden" name="id" value="'+data+'"></form>';
                    }
                }
            ],
        });
    } );

    function restorePendaftaranKelas(index){
            Swal.fire({
            title: 'Restore Pendaftaran Kelas ?',
            html: 
            '<p>Berikut merupakan effect apabila admin menghapus Pendaftaran Kelas</p>'+
            '<ul class="text-left">'+
            '<li>User yang sudah mendaftar sebelumnya akan mampu melihat pendaftaran kembali</li>'+
            '<li>Pendaftaran kelas yang telah direstore akan tampil di halaman index</li>'+
            '<li>Data pendaftaran akan sama seperti saat sebelum dihapus</li>'+
            '</ul>'
            ,
            icon:'warning',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Restore`,
            denyButtonText: `Batal`,
            }).then((result) => {
                
            if (result.isConfirmed) {
                $('#form-restore-'+index).submit();
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