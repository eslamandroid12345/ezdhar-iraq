<?php

namespace App\Models;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'title_ar',
        'title_en',
        'image',
        'limit',
    ];

    public function sub_categories(){

        return $this->hasMany(SubCategory::class,'category_id');
    }

    public function user(){

        return $this->hasMany(User::class,'category_id','id');
    }
}
