<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{   
    protected $table = 'notifications';
    
    protected $fillable = [
        'id','type','notifiable_type','notifiable_id','data','read_at','created_at','updated_at','deleted_at'
    ];

    public function getFullDataAttribute()
    {
        return $this->attributes['full_data'] = json_decode($this->data);
    }

    public function User(){
        return $this->belongsTo($this->notifiable_type,'notifiable_id','id');
    }
}
