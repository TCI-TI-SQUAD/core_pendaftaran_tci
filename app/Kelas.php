<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id_pendaftaran',
        'id_pengajar',
        'hsk',
        'nama_kelas',
        'tanggal_mulai',
        'tanggal_selesai',
        'isBerbayar',
        'harga',
        'kuota',
        'status',
        'logo_kelas'
    ];

    public function DetailKelas(){
        return $this->hasMany('App\DetailKelas','id_kelas','id');
    }

    public function KelasKerjasama(){
        return $this->hasMany('App\KelasKerjasama','id_kelas','id');
    }

    public function Pengajar(){
        return $this->belongsTo('App\Pengajar','id_pengajar','id');
    }
}
