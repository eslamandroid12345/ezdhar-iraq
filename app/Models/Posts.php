<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model{

    protected $table = 'post_providers';
    use HasFactory;
    protected $guarded=[];

    protected $appends=['likes_count','is_licked','is_followed','is_reported'];

    public function getIsReportedAttribute()
    {
        if (api()->check()){
            $count = PostsActions::where('type','report')
                ->where('post_id',$this->id)->count();

            if ($count)
                return true;
            return false;
        }
        return false;
    }//end fun
    /**
     * @return bool
     */
    public function getIsLickedAttribute()
    {
        if (api()->check()){
            $count = PostsActions::where('type','love')
                ->where('post_id',$this->id)->count();

            if ($count)
                return true;
            return false;
        }
        return false;
    }//end fun
    /**
     * @return bool
     */
    public function getIsFollowedAttribute()
    {
        if (api()->check()){
            $count = PostsActions::where('type','follow')
                ->where('post_id',$this->id)->count();

            if ($count)
                return true;
            return false;
        }
        return false;
    }//end fun
    /**
     * @return mixed
     */
    public function getLikesCountAttribute()
    {
        return PostsActions::where('type','love')
            ->where('post_id',$this->id)->count();
    }//end fun
    /**
     * @param $query
     * @return mixed
     */
    public function scopeFollowing($query)
    {
        return $query->wherehas('follows', function ($queryPost) {
            $queryPost->where('user_id', api()->user()->id);
        });
    }//end fun
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(PostsActions::class,'post_id')
            ->where('type','love');
    }//end fun
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function follows()
    {
        return $this->hasMany(PostsActions::class,'post_id')
            ->where('type','follow');
    }//end fun

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class,'provider_id','id');
    }
}//end class
