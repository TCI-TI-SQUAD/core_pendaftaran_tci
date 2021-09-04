@extends('admin.admin-layout.admin-layout')

@section('pendaftaran_kelas','active')

@section('page-name-header','Trashed Kelas')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.pendaftarankelas') }}">Pendaftaran Kelas</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.detail.pendaftarankelas',[$pendaftaran->id]) }}">Detail Pendaftaran Kelas</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.kelas',[$pendaftaran->id]) }}">Kelas</a></li>
<li class="breadcrumb-item active">Trashed Kelas</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <table>
            <tr>
                <th>Nama Pendaftaran :</th>
                <td>{{ $pendaftaran->nama_pendaftaran }}</td>
            </tr>
        </table>
    </div>
    <div class="col-12 jumbotron p-2 shadow">
        <table class="table responsive wrap" width="100%" id="table_id">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Nama kelas</th>
            <th scope="col">HSK</th>
            <th scope="col">Tanggal Mulai</th>
            <th scope="col">Tanggal Selesai</th>
            <th scope="col">Kuota</th>
            <th scope="col">Peserta</th>
            <th scope="col">Harga</th>
            <th scope="col">Status</th>
            <th scope="col">Created at</th>
            <th scope="col">Updated at</th>
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
                "url": "{{ Route('admin.ajax.trashed.kelas') }}",
                "type": "POST",
                "data":{
                    "_token": "{{ csrf_token() }}",
                    "id" : {{ $pendaftaran->id }}
                }
            },
            "columns": [
                { "data": "number" },
                { "data": "nama_kelas" },
                { "data": "hsk" },
                { "data": "tanggal_mulai" },
                { "data": "tanggal_selesai" },
                { "data": "kuota" },
                { "data": "detail_kelas_count" },
                {
                    data: "harga",title:"Harga",
                    render: function ( data, type, row, meta ) {
                        return 'Rp. '+data;
                    }
                },
                { "data": "status" },
                { "data": "created_at" ,"visible" :false},
                { "data": "updated_at" ,"visible" :false},
                {
                    data: "id",title:"Aksi",
                    render: function ( data, type, row, meta ) {
                        return '<a class="btn btn-sm btn-primary text-white" onclick="restoreKelas('+data+')"><i class="fas fa-trash-restore"></i></a><form id="form-restore-'+data+'" method="POST" style="display:none;" action="{{ route("admin.restore.trashed.kelas") }}"> @csrf @method("PUT") <input type="hidden" name="id" value="'+data+'"></form>';
                    }
                }
            ],
        });
    } );

    function restoreKelas(index){
            Swal.fire({
            title: 'Restore Kelas Ini ?',
            html: 
            '<p>Berikut merupakan effect apabila admin melakukan restore data kelas !</p>'+
            '<ul class="text-left">'+
            '<li>Kelas yang direstrore akan muncul kembali di halaman user</li>'+
            '<li>semua data kelas akan pulih baik jumlah peserta, jumlah transaksi dan lainnya</li>'+
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