<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalKelas extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'id_kelas',
        'hari'.
        'tanggal_waktu_mulai',
        'tanggal_waktu_selesai'
    ];
}
