<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeasibilityCategory extends Model
{
    use HasFactory;
    protected $table = 'feasibilities_categories';

    protected $fillable = [

        'feasibility_id',
        'price',
        'details'

    ];



    public function feasibility(){


        return $this->belongsTo(Feasibility::class,'feasibility_id','id');
    }


    public function FeasibilitySubCategory(){

        return $this->hasMany(FeasibilitySubCategory::class,'feasibility_category_id','id');

    }


}
