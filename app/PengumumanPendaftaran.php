<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengumumanPendaftaran extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id_pendaftaran',
        'id_admin',
        'pengumuman',
        'tanggal',
    ];
}
