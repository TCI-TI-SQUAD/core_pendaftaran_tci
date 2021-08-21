@extends('admin.admin-layout.admin-layout')

@section('siswa','active')

@section('page-name-header','Trashed Siswa')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.siswa') }}">Siswa</a></li>
<li class="breadcrumb-item">Trashed Siswa</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 jumbotron p-2 shadow">
        <table class="table responsive nowrap" width="100%" id="table_id">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Nama</th>
            <th scope="col">Username</th>
            <th scope="col">HSK</th>
            <th scope="col">Nomor Pelajar TCI</th>
            <th scope="col">Status</th>
            <th scope="col">email</th>
            <th scope="col">Phone Number</th>
            <th scope="col">Line</th>
            <th scope="col">Wa</th>
            <th scope="col">Alamat</th>
            <th scope="col">Hak Akses</th>
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
                "url": "{{ Route('admin.ajax.trashed.siswa') }}",
                "type": "POST",
                "data":{
                    "_token": "{{ csrf_token() }}"
                }
            },
            "columns": [
                { "data": "number" },
                { "data": "name" },
                { "data": "username" , "visible" : false},
                { "data": "hsk" },
                { "data": "nomor_pelajar_tci"},
                { "data": "status", "visible" : false},
                { "data": "email" },
                { "data": "phone_number" , "visible" : false},
                { "data": "line" , "visible" : false},
                { "data": "wa", "visible" : false },
                { "data": "alamat", "visible" : false },
                { "data": "hak_akses", "visible" : false },
                { "data": "created_at", "visible" : false },
                { "data": "updated_at", "visible" : false },
                {
                    data: "id",title:"Aksi",
                    render: function ( data, type, row ) {
                        return '<a class="btn text-white btn-sm btn-info" onclick="deleteSiswa('+data+')"><i class="fas fa-trash-restore"></i></a> <form id="delete-siswa-'+data+'" action="{{ route("admin.trashed.siswa.restore") }}" method="POST" style=" display: none;"> @csrf @method("PUT") <input name="id" value="'+data+'" type="hidden"></form>';
                    }
                }
            ]
        });
    } );

    function deleteSiswa(index){
            Swal.fire({
            title: 'Restore siswa ini ?',
            html: 
            '<p>Berikut merupakan effect apabila admin merestore user</p>'+
            '<ul class="text-left">'+
            '<li>User akan dapat login ke dalam sistem kembali</li>'+
            '<li>Data user akan tetap, baik pendaftaran, kelas dan lain-lain</li>'+
            '<li>Kelas kemungkinan akan melebihi kapasitas apabila saat sebelum dipulihkan kelas user ini sudah full</li>'+
            '<li>Mohon pastikan semua administrasi user ini sudah lengkap untuk mencegah hal yang tidak diinginkan</li>'+
            '</ul>'
            ,
            icon:'warning',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Restore`,
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