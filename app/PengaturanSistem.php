<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengaturanSistem extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'id_admin',
        'nama_pengaturan',
        'keterangan',
        'pengaturan',
        'status',
    ];
}
