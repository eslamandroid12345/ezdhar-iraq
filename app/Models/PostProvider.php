<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostProvider extends Model
{
    use HasFactory;
    protected $table = 'post_providers';
    protected $fillable = [

        'description',
        'image',
        'provider_id',
        'status'

    ];


    public function provider(){

        return $this->belongsTo(User::class, 'provider_id', 'id');
    }


    public function post_provider_actions(){


        return $this->hasMany(PostProviderAction::class,'post_provider_id','id');

    }
}
