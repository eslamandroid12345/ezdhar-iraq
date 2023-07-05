<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeasibilityType extends Model{


     protected $table = 'feasibility_types';
     protected $fillable = [

         'type',
         'img',

     ];


    public function feasibility(){

        return $this->hasMany(Feasibility::class, 'feasibility_type_id', 'id');

    }


}
