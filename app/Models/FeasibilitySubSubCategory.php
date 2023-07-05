<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeasibilitySubSubCategory extends Model
{
    use HasFactory;
    protected $table = 'feasibilities_sub_sub_categories';

    protected $fillable = [

        'feasibility_sub_category_id',
        'price',
        'details'

    ];



    public function FeasibilitySubCategory(){

        return $this->belongsTo(FeasibilitySubCategory::class,'feasibility_sub_category_id','id');

    }


}
