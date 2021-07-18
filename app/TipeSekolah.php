<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipeSekolah extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'nama_tipe'
    ];

    public function Sekolah(){
        return $this->hasMany('App\Sekolah','id_tipe_sekolah','id');
    }
}
