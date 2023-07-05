<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Rate;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ConsultantTypes;
use App\Models\Cities;
use App\Models\Advisor_Category;
use App\Models\SubCategory;
use App\Models\Room;

class ProviderResource extends JsonResource
{

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

                'consultant_type_id'=>$this->category_id,
                'consultant_type'=>new CategoryResources(Category::find($this->category_id)),
                'years_ex'=>$this->years_ex,
                'consultant_price'=>$this->consultant_price,
                'bio'=>$this->bio,
                'count_people'=>Room::where('adviser_or_freelancer_id',$this->id)->groupBy('user_id')->count(),
                'rate'=> (int)Rate::where('provider_id','=',$this->id)->sum('rate_number') / Rate::where('provider_id','=',$this->id)->count('id') ,
                'graduation_rate'=>$this->graduation_rate
            ],
            'main_category' => new CategoryResources(Category::find($this->category_id)),
            'sub_categories' =>  AdviserWithSubCategoryResources::collection($this->advisor_category),
            'access_token'=>'Bearer '.$this->token??'',
            'token_type'=>'bearer',
        ];
    }
}
