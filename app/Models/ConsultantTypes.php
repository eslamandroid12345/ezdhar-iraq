<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultantTypes extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'consultant_types';


    public function user(){

        return $this->hasMany(User::class,'consultant_type_id','id');
    }
}
