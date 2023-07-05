<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderReport extends Model
{
    use HasFactory;
    protected $table = 'order_reports';
    protected $guarded = [];





    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function provider(){
        return $this->belongsTo(User::class,'provider_id','id');
    }

    public function order(){

        return $this->belongsTo(ServiceRequest::class,'id','order_id');
    }




}
