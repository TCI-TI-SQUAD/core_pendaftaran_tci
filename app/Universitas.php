<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Universitas extends Model
{
    use SoftDeletes;

    public function Fakultas(){
        return $this->hasMany('App\Fakultas','id_universitas','id');
    }
}
