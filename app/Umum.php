<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Umum extends Model
{
    protected $fillable = [
        'nama',
        'keterangan',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
