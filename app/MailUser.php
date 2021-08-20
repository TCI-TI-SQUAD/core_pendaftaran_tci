<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailUser extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'subject',
        'message',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
