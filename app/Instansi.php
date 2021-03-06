<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instansi extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'id',
        'nama_instansi',
        'keterangan'
    ];
}
