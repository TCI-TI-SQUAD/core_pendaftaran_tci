<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajar extends Model
{
    protected $fillable = [
        'nama_pengajar',
        'foto_pengajar',
        'keterangan_pengajar',
    ];
}
