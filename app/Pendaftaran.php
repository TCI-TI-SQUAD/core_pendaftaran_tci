<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pendaftaran extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'nama_pendaftaran','tanggal_mulai','tanggal_selesai','status','keterangan'
    ];

    public function Kelas(){
        return $this->hasMany('App\Kelas','id_pendaftaran','id');
    }

    public function PengumumanPendaftaran(){
        return $this->hasMany('App\PengumumanPendaftaran','id_pendaftaran','id');
    }
}
