<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $table = 'rate_providers';
    protected $fillable = [

        'rate_number',
        'details',
        'user_id',
        'provider_id',


    ];

    public function user(){


        return $this->belongsTo(User::class,'user_id','id');

    }

    public function provider(){

        return $this->belongsTo(User::class,'provider_id','id');


    }
}
