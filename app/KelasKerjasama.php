<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KelasKerjasama extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'id_kelas',
        'id_instansi',
        'status',
    ];
}
