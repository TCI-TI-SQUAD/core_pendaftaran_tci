<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fakultas extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id_instansi',
        'nama_fakultas',
        'keterangan'
    ];

    public function Universitas(){
        return $this->belongsTo('App\Universitas','id_universitas','id');
    }

    public function Prodi(){
        return $this->hasMany('App\Prodi','id_fakultas','id');
    }
}
