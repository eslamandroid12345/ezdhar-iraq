<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeasibilitySubCategory extends Model
{
    use HasFactory;
    protected $table = 'feasibilities_sub_categories';
    protected $fillable = [

        'feasibility_category_id',
        'price',
        'details'

    ];


    public function feasibilityCategory(){

        return $this->belongsTo(FeasibilityCategory::class,'user_id','id');

    }

    public function FeasibilitySubSubCategory(){

        return $this->hasMany(FeasibilitySubSubCategory::class,'feasibility_sub_category_id','id');

    }


}
