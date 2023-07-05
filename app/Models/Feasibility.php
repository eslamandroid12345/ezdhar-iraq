<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feasibility extends Model{


    protected $table = 'feasibilities';
     protected $fillable = [

         'feasibility_type_id',
         'img',
         'project_name',
         'ownership_rate',
         'show',
         'note',
         'details',
         'show',
         'user_id',


     ];


    public function feasibilityType(){

        return $this->belongsTo(FeasibilityType::class,'feasibility_type_id','id');


    }

      public function user(){

          return $this->belongsTo(User::class,'user_id','id');


      }



}
