<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengajar extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'nama_pengajar',
        'foto_pengajar',
        'keterangan_pengajar',
    ];
}
