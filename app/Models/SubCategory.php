<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = 'sub_categories';

    protected $guarded = [];

    protected $fillable = [
        'category_id',
        'title_ar',
        'title_en',
        'terms_ar',
        'terms_en',
        'image',
    ];

    public $timestamps = false;

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }



    public function orders(){
        return $this->hasMany(Order::class,'sub_category_id');
    }



    public function advisor_category(){


        return $this->hasMany(Advisor_Category::class,'category_type_id','id');

    }


    public function service_request(){


        return $this->hasMany(ServiceRequest::class,'sub_category_id','id');

    }

}
