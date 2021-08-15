<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = [
        'nama_admin','username','password','email','phone_number','line','wa','status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
