<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advisor_Category extends Model
{
    use HasFactory;
    protected $table = "advisor_categories";
    protected $guarded = [];




    public function user(){


        return $this->belongsTo(User::class,'user_id','id');

    }

    public function sub_category(){


        return $this->belongsTo(SubCategory::class,'sub_category_id','id');

    }



}
