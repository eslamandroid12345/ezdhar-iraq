<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class FreelancerSubCategoryResources extends JsonResource
{

    public function toArray($request){

        return [

            "id" => $this->id,
            "details" => lang() == 'ar' ? $this->desc_ar : $this->desc_en,
            "price" => number_format($this->price,2),
            "freelancer" => new UserResources($this->user),
            "services" => new SubCategoryResources($this->sub_category),

        ];
    }
}
