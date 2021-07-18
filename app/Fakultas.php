<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $fillable = [
        'id_instansi',
        'nama_fakultas',
        'keterangan'
    ];

    public function Prodi(){
        return $this->hasMany('App\Prodi','id_fakultas','id');
    }
}
