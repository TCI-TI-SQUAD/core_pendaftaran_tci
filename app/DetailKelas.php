<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailKelas extends Model
{
    use SoftDeletes;
    
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
