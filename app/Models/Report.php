<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';
    protected $fillable = [

        'reason',
        'details',
        'photo',
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
