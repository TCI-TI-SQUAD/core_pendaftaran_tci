<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Pendaftaran extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'nama_pendaftaran','tanggal_mulai_pendaftaran','tanggal_selesai_pendaftaran','status','keterangan','created_at','archived_at','deleted_at'
    ];

    public function Kelas(){
        return $this->hasMany('App\Kelas','id_pendaftaran','id');
    }

    public function PengumumanPendaftaran(){
        return $this->hasMany('App\PengumumanPendaftaran','id_pendaftaran','id');
    }
}
