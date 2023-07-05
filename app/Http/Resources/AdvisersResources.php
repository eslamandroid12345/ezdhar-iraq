<?php

namespace App\Http\Resources;

use App\Models\Cities;
use App\Models\ConsultantTypes;
use App\Models\Room;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvisersResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'user'=>[
                'id'=>$this->id,
                'first_name'=>$this->first_name,
                'last_name'=>$this->last_name,
                'phone_code'=>$this->phone_code,
                'phone'=>$this->phone,
                'email'=>$this->email,
                'image'=>get_file($this->image),
                'birthdate'=>$this->birthdate,
                'user_type'=>$this->user_type,
                'city_id'=>$this->city_id,
                'wallet'=>$this->wallet,
                'city'=>new CityResources(Cities::find($this->city_id)),
            ],
            'adviser_data'=>[
                'consultant_type_id'=>$this->consultant_type_id,
                'consultant_type'=>new ConsultantTypeResources(ConsultantTypes::find($this->consultant_type_id)),
                'years_ex'=>$this->years_ex,
                'consultant_price'=>$this->consultant_price,
                'bio'=>$this->bio,
                'count_people'=>Room::where('adviser_id',$this->id)->groupBy('user_id')->count(),
                'rate'=>0.5,
                'graduation_rate'=>$this->graduation_rate
            ],
            'access_token'=>'Bearer '.$this->token??'',
            'token_type'=>'bearer'
        ];
    }
}
