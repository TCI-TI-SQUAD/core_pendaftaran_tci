<div class="col-12 pt-5">
    <div class="container jumbotron shadow p-0 w-100">
        <div class="row">
            <div class="col-12">
                <h5 class="p-2 bg-primary font-weight-bold text-center text-lg-left">REGISTRASI BARU HARI INI</h5>
            </div>
            <div class="col-12 p-3">
                
                    <table class="table responsive nowrap" width="100%" id="table_id">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">HSK</th>
                        <th scope="col">Nomor Pelajar TCI</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($users))
                            @if(count($users) > 0)
                                @foreach($users as $index => $user)
                                    <tr>
                                    <th scope="row">{{ $index+1 }}</th>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ strtoupper($user['hsk']) }}</td>
                                    <td>{{ $user['nomor_pelajar_tci'] }}</td>
                                    <td><button class="btn-primary rounded"><i class="far fa-eye"></i></button><button class="btn-info rounded"><i class="fas fa-edit"></i></button></td>
                                    </tr>
                                @endforeach
                            @endif
                        @endif
                    </tbody>
                    </table>

                
            </div>
        </div>
    </div>
</div>

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
            responsive: true
        });
    } );
</script>
@endpush