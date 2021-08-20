@extends('admin.admin-layout.admin-layout')

@section('siswa','active')

@section('page-name-header','E-Mail Siswa')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.siswa') }}">Siswa</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.detail.siswa',[$user->id]) }}">Detail Siswa</a></li>
<li class="breadcrumb-item">E-Mail Siswa</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <a href="{{ Route('admin.email.siswa.create',[$user->id]) }}" class="btn btn-sm btn-success"><i class="far fa-edit"></i> BUAT E-MAIL BARU</a>
    </div>
    <div class="col-12 jumbotron p-2 shadow">
        <table class="table responsive nowrap" width="100%" id="table_id">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Message</th>
            <th scope="col">Subject</th>
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
    $(document).ready( function () {

        $('#table_id').DataTable({
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
                "url": "{{ Route('admin.ajax.email.siswa') }}",
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
                { "data": "subject"},
                {
                    data: "id",title:"Aksi",
                    render: function ( data, type, row ) {
                        return '<a href="{{ route("admin.detail.siswa") }}/'+data+'" class="btn btn-sm btn-primary"><i class="far fa-eye"></i></a><a href="{{ route("admin.edit.siswa") }}/'+data+'" class="btn text-white btn-sm btn-info"><i class="far fa-edit"></i></a><a class="btn text-white btn-sm btn-danger" onclick="deleteEmailSiswa('+data+')"><i class="far fa-trash-alt"></i></a> <form id="delete-email-siswa-'+data+'" action="{{ route("admin.delete.siswa") }}" method="POST" style=" display: none;"> @csrf @method("DELETE") <input name="id" value="'+data+'" type="hidden"></form>';
                    }
                }
            ],
            columnDefs: [{
                            render: function (data, type, full, meta) {
                                return "<div id='dvNotes' style='white-space: normal;width: 250px;'>" + data + "</div>";
                            },
                            targets: 2
                        }]
        });
    } );

    function deleteEmailSiswa(index){
            Swal.fire({
            title: 'Hapus siswa ini ?',
            html: 
            '<p>Berikut merupakan effect apabila admin menghapus e-mail user</p>'+
            '<ul class="text-left">'+
            '<li>E-mail yang sudah sampai ke E-mail user <span class="text-danger">TIDAK AKAN</span> ikut terhapus </li>'+
            '<li>catatan e-mail yang telah dihapus tidak akan dapat dipulihkan kembali</li>'+
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