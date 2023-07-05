<?php

namespace App\Http\Resources;

use App\Models\Cities;
use Illuminate\Http\Resources\Json\JsonResource;

class BasicUserResources extends JsonResource
{

    public function toArray($request){
        
        return [

            'id'=>$this->id,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'phone_code'=>$this->phone_code,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'image'=>get_file($this->image),
            'birthdate'=>$this->birthdate,
            'user_type'=>$this->user_type,
            'wallet'=>$this->wallet,
            'city'=>new CityResources(Cities::find($this->city_id)),
        ];
    }
}
