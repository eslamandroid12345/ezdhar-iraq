<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class AdviserWithSubCategoryResources extends JsonResource
{

    public function toArray($request){

        return [

            "id" => $this->id,
            "desc_ar" => $this->desc_ar,
            "desc_en" => $this->desc_en,
            "price" => (int)number_format($this->price,2),
            'sub_category_id' => $this->sub_category_id,
            "service" => new SubCategoryResources($this->sub_category),
        ];
    }
}
