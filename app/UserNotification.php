<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $table = 'notifications';
    protected $guarded = [];

    public function setFullDataAttribute($value)
    {
        $this->attributes['full_data'] = json_decode($value);
    }

}
