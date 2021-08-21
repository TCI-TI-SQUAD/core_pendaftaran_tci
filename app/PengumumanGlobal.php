<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengumumanGlobal extends Model
{
    protected $fillable = [
        'id_admin',
        'pengumuman',
        'tanggal',
    ];

    public function Admin(){
        return $this->belongsTo("App\Admin","id_admin","id");
    }
}
