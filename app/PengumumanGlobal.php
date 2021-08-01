<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengumumanGlobal extends Model
{
    protected $fillable = [
        'id_admin',
        'pengumuman',
        'tanggal',
    ];
}
