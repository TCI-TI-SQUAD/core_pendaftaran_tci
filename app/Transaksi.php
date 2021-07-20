<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id_admin',
        'id_detail_kelas',
        'nama_kelas',
        'nama_pendaftaran',
        'nomor_transaksi_struct',
        'total_pembayaran',
        'file_bukti_transaksi',
        'file_struct_pembayaran',
        'nama_pemesan',
        'nomor_pelajar_tci',
        'tanggal_cetak_struct',
        'tanggal_mulai_kelas',
        'tanggal_selesai_kelas',
        'status',
        'keterangan_pembayaran_user',
        'keterangan_tambahan_in_struct',
        'keterangan_tambahan_out_struct',
        'menyetujui_admin',
    ];

    public function DetailKelas(){
        return $this->belongsTo('App\DetailKelas','id_detail_kelas','id');
    }
}
