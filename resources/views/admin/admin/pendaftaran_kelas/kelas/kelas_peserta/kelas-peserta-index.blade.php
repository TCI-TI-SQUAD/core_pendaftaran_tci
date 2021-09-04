@extends('admin.admin-layout.admin-layout')

@section('pendaftaran_kelas','active')

@section('page-name-header','Peserta Kelas')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.pendaftarankelas') }}">Pendaftaran Kelas</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.detail.pendaftarankelas',[$pendaftaran->id]) }}">Detail Pendaftaran Kelas</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.kelas',[$pendaftaran->id]) }}">Kelas</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.detail.kelas',[$kelas->id]) }}">Detail Kelas</a></li>
<li class="breadcrumb-item active">Peserta Kelas</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <table>
            <tr>
                <th>Nama Kelas :</th>
                <td>{{ $kelas->nama_kelas }}</td>
            </tr>
        </table>
    </div>
    <div class="col-12 jumbotron p-2 shadow">
        <table class="table responsive wrap" width="100%" id="table_id">
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
                "url": "{{ route('admin.ajax.peserta.kelas.index') }}",
                "type": "POST",
                "data":{
                    "_token": "{{ csrf_token() }}",
                    "id" : "{{ $kelas->id }}"
                }
            },
            "columns": [
                {"data" : "number","title" : "#"},
                {"data" : "user.name","title" : "Name"},
                {"data" : "user.username","title" : "Username","visible":false},
                {"data" : "user.hsk","title" : "HSK",
                    render: function(data,type,row,meta){
                        return data.toUpperCase();
                    }
                },
                {"data" : "user.nomor_pelajar_tci","title" : "Nomor Pelajar TCI"},
                {"data" : "user.email","title" : "Email"},
                {"data" : "user.phone_number","title" : "Phone Number","visible":false},
                {"data" : "user.line","title" : "Line","visible":false},
                {"data" : "user.wa","title" : "Wa","visible":false},
                {"data" : "user.alamat","title" : "Alamat","visible":false},
                {"data" : "user.hak_akses","title" : "Hak Akses","visible":false},
                {"data" : "transaksi.status","title" : "Status Transaksi",
                    render: function(data,type,row,meta){
                        return data.replace(/_/g, " ").toUpperCase();
                    }
                },
                {
                    data: "id",title:"Aksi",
                    render: function ( data, type, row, meta ) {
                        return '<a href="{{ route("admin.detail.siswa") }}/'+row["user"]["id"]+'" target="__blank" class="btn btn-sm btn-primary"><i class="far fa-eye"></i></a><a href="{{ route("admin.edit.siswa") }}/'+row["user"]["id"]+'" target="__blank" class="btn text-white btn-sm btn-info"><i class="far fa-edit"></i></a><a class="btn text-white btn-sm btn-danger" onclick="deletePesertaKelas('+data+')"><i class="fas fa-user-times"></i></a><a class="btn text-white btn-sm btn-warning"><i class="fas fa-file-invoice-dollar"></i></a><form id="delete-pendaftaran-kelas-'+data+'" action="{{ route("admin.delete.kelas") }}" method="POST" style=" display: none;"> @csrf @method("DELETE") <input name="id_pendaftaran" value="{{ $pendaftaran->id }}"/> <input name="id" value="'+data+'" type="hidden"></form><form id="form-archived-'+data+'" method="POST" style="display:none;" action="{{ route("admin.archived.pendaftarankelas") }}"> @csrf @method("PUT") <input type="hidden" name="id" value="'+data+'"></form>';
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

    function deletePesertaKelas(index){
            Swal.fire({
            title: 'Keluarkan Peserta Kelas Ini ?',
            html: 
            '<p>Berikut merupakan effect apabila admin menghapus Peserta Kelas</p>'+
            '<ul class="text-left">'+
            '<li>Peserta kelas akan dikeluarkan dari kelas !</li>'+
            '<li><span class="font-weight-bold text-danger">TRANSAKSI, INVOICE, dan SEMUA DATA</span> yang berkaitan dengan kelas ini <span class="font-weight-bold text-danger">TIDAK AKAN BISA DIAKSES</span> kembali oleh peserta kelas yang sudah dihapus dari kelas</li>'+
            '<li>Peserta yang telah dihapus dari kelas ini <span class="text-danger font-weight-bold">TIDAK DAPAT</span> dipulihkan</li>'+
            '<li>Jadi mohon untuk menggunakan fitur ini dengan bijak</li>'+
            '<li>Aksi ini memerlukan password admin untuk melanjutkannya</li>'+
            '</ul>' +
            '<label>PASSWORD ADMIN</label><br>'+
            '<input id="pass_admin_'+index+'" name="password" type="password" form="delete-pendaftaran-kelas-'+index+'" class="form-control border border-danger" placeholder="Password admin diperlukan"/>'
            ,
            icon:'warning',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Delete`,
            denyButtonText: `Batal`,
            }).then((result) => {
                
            if (result.isConfirmed) {
                if($("#pass_admin_"+index).val()){
                    $('#delete-pendaftaran-kelas-'+index).submit();
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Admin Diperlukan !',
                        text: 'Aksi merupakan tindakan yang krusial, diperlukan password admin untuk melanjutkan',
                    })
                }
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