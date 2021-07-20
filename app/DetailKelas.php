<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailKelas extends Model
{
    protected $fillable = [
        'id_kelas',
        'id_user',
        'nomor_pelajar_kelas',
        'nilai',
    ];

    public function Kelas(){
        return $this->belongsTo('App\Kelas','id_kelas','id');
    }

    public function Transaksi(){
        return $this->hasOne('App\Transaksi','id_detail_kelas','id');
    }
}
