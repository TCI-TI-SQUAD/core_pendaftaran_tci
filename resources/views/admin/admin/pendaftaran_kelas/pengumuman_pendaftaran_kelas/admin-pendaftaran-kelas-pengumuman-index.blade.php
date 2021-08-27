@extends('admin.admin-layout.admin-layout')

@section('pendaftaran_kelas','active')

@section('page-name-header','Pengumuman Pendaftaran Kelas')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.pendaftarankelas') }}">Pendaftaran Kelas</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.detail.pendaftarankelas',[$pendaftaran->id]) }}">Detail Pendaftaran Kelas</a></li>
<li class="breadcrumb-item active">Pengumuman Pendaftaran Kelas</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <a href="{{ route('admin.create.pengumuman.pendaftarankelas',[$pendaftaran->id]) }}" class="btn btn-sm btn-success"><i class="far fa-edit"></i> BUAT PENGUMUMAN BARU</a>
    </div>
    <div class="col-12 jumbotron p-2 shadow">
        <table class="table responsive wrap" width="100%" id="table_id">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Nama Admin</th>
            <th scope="col">Pesan Pengumuman</th>
            <th scope="col">Tanggal</th>
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
                "url": "{{ Route('admin.ajax.pengumuman.pendaftarankelas') }}",
                "type": "POST",
                "data":{
                    "_token": "{{ csrf_token() }}",
                    "id" : {{ $pendaftaran->id }}
                }
            },
            "columns": [
                { "data": "number" },
                { "data": "admin.nama_admin" },
                { "data": "pengumuman","visible" : false },
                { "data": "tanggal" },
                {
                    data: "id",title:"Aksi",
                    render: function ( data, type, row, meta ) {
                        return '<button onclick="detailData('+meta.row+')" class="btn btn-sm btn-primary"><i class="far fa-eye"></i></button><a href="{{ route("admin.edit.siswa") }}/'+data+'" class="btn text-white btn-sm btn-info"><i class="far fa-edit"></i></a><a class="btn text-white btn-sm btn-danger" onclick="deletePengumumanSistem('+data+')"><i class="far fa-trash-alt"></i></a> <form id="delete-pengumuman-'+data+'" action="{{ route("admin.delete.pengumuman.pendaftarankelas") }}" method="POST" style=" display: none;"> @csrf @method("DELETE") <input name="id" value="'+data+'" type="hidden"></form>';
                    }
                }
            ],
            columnDefs: [{
                            render: function (data, type, full, meta) {
                                return "<div id='dvNotes' style='padding:0px;margin:0;white-space: normal;width: 300px;font-size:12px;'>" + data + "</div>";
                            },
                            targets: 2
                        }]
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

    function deletePengumumanSistem(index){
            Swal.fire({
            title: 'Hapus Pengumuman Sistem Ini ?',
            html: 
            '<p>Berikut merupakan effect apabila admin menghapus user</p>'+
            '<ul class="text-left">'+
            '<li>User tidak akan bisa melihat pengumuman yang telah dihapus</li>'+
            '<li>Pengumuman yang telah dihapus tidak akan dapat <span class="text-danger">DIKEMBALIKAN</span></li>'+
            '</ul>'
            ,
            icon:'warning',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Hapus`,
            denyButtonText: `Batal`,
            }).then((result) => {
                
            if (result.isConfirmed) {
                $('#delete-pengumuman-'+index).submit();
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