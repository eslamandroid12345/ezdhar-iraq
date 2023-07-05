<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function service_request(){

        return $this->hasOne(ServiceRequest::class,'room_id');
    }

    public function adviser_or_freelancer(){
        return $this->belongsTo(User::class,'adviser_or_freelancer_id');
    }
}
