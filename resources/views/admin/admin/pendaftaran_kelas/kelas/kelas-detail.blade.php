@extends('admin.admin-layout.admin-layout')

@section('pendaftaran_kelas','active')

@section('page-name-header','Create Kelas')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.pendaftarankelas') }}">Pendaftaran Kelas</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.detail.pendaftarankelas',[$pendaftaran->id]) }}">Detail Pendaftaran Kelas</a></li>
<li class="breadcrumb-item active"><a href="{{ route('admin.kelas',[$pendaftaran->id]) }}">Kelas</a></li>
<li class="breadcrumb-item active">Detail Kelas</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <a href="{{ route('admin.create.pengumuman.sistem') }}" class="btn btn-sm btn-info"><i class="far fa-edit"></i> EDIT KELAS </a>
        <a href="" class="btn btn-sm btn-secondary"><i class="far fa-edit"></i> LIHAT PESERTA </a>
        <button onclick="deleteKelas()" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i> HAPUS KELAS </button>
        <a href="" class="btn btn-sm btn-warning"><i class="fas fa-bullhorn"></i> PENGUMUMAN KELAS</a>
        <form action="{{ route('admin.delete.kelas') }}" method="POST" id="form-delete-kelas">
            @csrf
            @method("DELETE")
            <input type="hidden" name="id_pendaftaran" value="{{ $pendaftaran->id }}">
            <input type="hidden" name="id" value="{{ $kelas->id }}">
        </form>
    </div>
    <div class="col-12 mb-3">
        <table>
            <tr>
                <th>Nama Pendaftaran :</th>
                <td>{{ $pendaftaran->nama_pendaftaran }}</td>
            </tr>
        </table>
    </div>
    <div class="col-12 jumbotron p-2">
        <div class="row">
            <div class="col-12 text-center" target="__blank">
                <a href="{{ asset('storage/image_kelas/'.$kelas->logo_kelas) }}">
                    <img src="{{ asset('storage/image_kelas/'.$kelas->logo_kelas) }}" alt="GAMBAR LOGO KELAS" class="img-thumbnail rounded w-100 d-inline-block d-md-none">
                    <img src="{{ asset('storage/image_kelas/'.$kelas->logo_kelas) }}" alt="GAMBAR LOGO KELAS" class="img-thumbnail rounded w-50 d-none d-md-inline-block">
                </a>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 col-lg-6">
                <label>Nama Kelas</label>
                <input type="text"  class="form-control" value="{{ $kelas->nama_kelas }}" readonly>
            </div>

            <div class="col-12 col-lg-6">
                <label>HSK</label>
                <input type="text"  class="form-control" value="{{ strtoupper($kelas->hsk) }}" readonly>
            </div>

            <div class="col-12 col-lg-6">
                <label>TANGGAL MULAI</label>
                <input type="text"  class="form-control" value="{{ Carbon\Carbon::create($kelas->tanggal_mulai)->translatedFormat('l, Y F d') }}" readonly>
            </div>

            <div class="col-12 col-lg-6">
                <label>TANGGAL SELESAI</label>
                <input type="text"  class="form-control" value="{{ Carbon\Carbon::create($kelas->tanggal_selesai)->translatedFormat('l, Y F d') }}" readonly>
            </div>

            <div class="col-12 col-lg-6">
                <label>BERBAYAR</label>
                <input type="text"  class="form-control" value="@if($kelas->isBerbayar) BERBAYAR @else GRATIS @endif" readonly>
            </div>

            <div class="col-12 col-lg-6">
                <label>HARGA</label>
                <input type="text"  class="form-control" value="Rp. {{ number_format($kelas->harga,0,'.','.') }}" readonly>
            </div>

            <div class="col-12 col-lg-6">
                <label>KUOTA</label>
                <input type="text"  class="form-control" value="{{ $kelas->kuota }} Orang" readonly>
            </div>

            <div class="col-12 col-lg-6">
                <label>PESERTA</label>
                <input type="text"  class="form-control" value="{{ $kelas->detail_kelas_count }} Orang" readonly>
            </div>

            <div class="col-12">
                <label>STATUS</label>
                <input type="text"  class="form-control" value="{{ strtoupper($kelas->status) }}" readonly>
            </div>

            <div class="col-12 mt-3">
                <label for="">DATA DIAKSES :</label>
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">UMUM</h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <ul>
                                    @if(isset($umum))
                                        @if(!$umum->isEmpty())
                                            @foreach($umum as $index => $data_umum)
                                                <li>{{ $data_umum->getInstansiName() }}</li>
                                            @endforeach
                                        @else
                                            TIDAK ADA DATA
                                        @endif
                                    @else
                                        TIDAK ADA DATA
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="card-title">SISWA</h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <ul>
                                    @if(isset($siswa))
                                        @if(!$siswa->isEmpty())
                                            @foreach($siswa as $index => $data_siswa)
                                                <li>{{ $data_siswa->getInstansiName() }}</li>
                                            @endforeach
                                        @else
                                            TIDAK ADA DATA
                                        @endif
                                    @else
                                        TIDAK ADA DATA
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title">MAHASISWA</h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <ul>
                                    @if(isset($mahasiswa))
                                        @if(!$mahasiswa->isEmpty())
                                            @foreach($mahasiswa as $index => $data_mahasiswa)
                                                <li>{{ $data_mahasiswa->getInstansiName() }}</li>
                                            @endforeach
                                        @else
                                            TIDAK ADA DATA
                                        @endif
                                    @else
                                        TIDAK ADA DATA
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-warning">
                        <h3 class="card-title">INSTANSI</h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <ul>
                                    @if(isset($instansi))
                                        @if(!$instansi->isEmpty())
                                            @foreach($instansi as $index => $data_instansi)
                                                <li>{{ $data_instansi->getInstansiName() }}</li>
                                            @endforeach
                                        @else
                                            TIDAK ADA DATA
                                        @endif
                                    @else
                                        TIDAK ADA DATA
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    $(document).ready(function(){
        $("[data-card-widget='collapse']").click()
    });

    function deleteKelas(){
        Swal.fire({
        title: 'Delete Kelas Ini ?',
        html: 
        '<p>Berikut merupakan effect apabila admin menghapus Kelas</p>'+
        '<ul class="text-left">'+
        '<li>User yang telah mendaftar / terkonfirmasi / membayar <span class="text-danger">tidak akan dapat melihat</span> kelas ini kembali</li>'+
        '<li>Kelas masih dapat dikembalikan setelah dihapus dair halaman <span class="text-info">TRASHED KELAS</span></li>'+
        '<li>Kelas yang sudah dikembalikan akan memiliki data yang sama dengan data sebelum dihapus</li>'+
        '<li>Apabila kelas sudah tidak diperlukan admin lebih baik melakukan <span class="text-warning">ARCHIVED</span> kelas</li>'+
        '</ul>'
        ,
        icon:'warning',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: `Delete`,
        denyButtonText: `Batal`,
        }).then((result) => {
            
        if (result.isConfirmed) {
            $('#form-delete-kelas').submit();
        } else if (result.isDenied) {

        }
        })
    }
</script>
@endpush