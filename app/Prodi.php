<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $fillable = [
        'id_fakultas',
        'nama_prodi',
        'keterangan',
    ];

    protected $casts = [
        'id' => EncryptCast::class,
        'id_fakultas' => EncryptCast::class,
    ];
}
