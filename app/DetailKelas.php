<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailKelas extends Model
{
    protected $fillable = [
        'id_kelas',
        'id_user',
        'nomor_pelajar_kelas',
        'nilai',
    ];
}
