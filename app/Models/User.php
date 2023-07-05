<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    protected $hidden = ['pivot'];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }//end getJWTIdentifier

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }//end of getJWTCustomClaims


    public function orders(){

        return $this->hasMany(Order::class, 'user_id', 'id');
    }



    public function category(){

        return $this->belongsTo(Category::class,'category_id','id');
    }


    public function consultant_type(){

        return $this->belongsTo(ConsultantTypes::class,'consultant_type_id	','id');
    }



    public function advisor_category(){


        return $this->hasMany(Advisor_Category::class,'user_id','id');

    }


    public function service_request_user(){


        return $this->hasMany(ServiceRequest::class,'user_id','id');

    }


    public function service_request_provider(){


        return $this->hasMany(ServiceRequest::class,'provider_id','id');

    }


        public function post_provider_action(){


            return $this->hasOne(PostProviderAction::class,'user_id','id');

        }

  
}
