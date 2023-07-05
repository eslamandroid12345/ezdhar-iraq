<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function provider(){

        return $this->belongsTo(User::class,'provider_id','id');
    }

    public function room(){

        return $this->belongsTo(Room::class,'room_id','id');
    }

    public function sub_category(){
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }



}
