<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostProviderAction extends Model
{
    use HasFactory;
    protected $table = 'posts_providers_actions';
    protected $fillable = [

        'post_provider_id',
        'user_id',
        'action'

    ];


    public function post_provider(){

        return $this->belongsTo(PostProvider::class, 'post_provider_id', 'id');
    }


    public function user(){

        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
