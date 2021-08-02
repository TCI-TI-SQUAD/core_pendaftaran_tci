<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LinkKelas extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id_kelas',
        'nama_link',
        'icon_link',
        'link',
        'keterangan',
    ];
}
