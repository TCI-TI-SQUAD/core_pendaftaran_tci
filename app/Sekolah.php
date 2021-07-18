<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $fillable = [
        'id_tipe_sekolah',
        'nama_sekolah',
        'keterangan'
    ];
}
