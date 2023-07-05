<?php

namespace App\Http\Resources;

use App\Models\Cities;
use App\Models\Room;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderOneResources extends JsonResource
{

    public function toArray($request)
    {

        return [

            "user" => [

                'id'=>$this->id,
                'first_name'=>$this->first_name,
                'last_name'=>$this->last_name,
                'phone_code'=>$this->phone_code,
                'phone'=>$this->phone,
                'email'=>$this->email,
                'image'=> asset($this->image),
                'birthdate'=>$this->birthdate,
                'user_type'=>$this->user_type,
                'city_id'=> (int)$this->city_id,
                'wallet'=>$this->wallet,
                'city'=>new CityResources(Cities::find($this->city_id)),
                'share' => (!is_null($request->provider_id) && !is_null($request->sub_category_id)) ? asset('/' . $request->provider_id . '/' . $request->sub_category_id) : null,
                'access_token'=>'Bearer '.$this->token??'',
                'token_type'=>'bearer',
                'consultant' => $this->consultant_type ?  new ConsultantTypeResources($this->consultant_type) : null,
                'main_category' => $this->category ? new CategoryResources($this->category) : null,
                'advisor_category' =>  AdviserWithSubCategoryResources::collection($this->advisor_category),

                
            ],



        ];
    }
}
