<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipeKelas extends Model
{
    protected $fillable = [
        'nama_tipe',
        'keterangan_tipe',
        'warna_tipe',
    ];
}
