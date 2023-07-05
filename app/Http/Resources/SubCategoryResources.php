<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResources extends JsonResource
{

    public function toArray($request)
    {
        return [

            'id'=>$this->id,
            'title_ar'=> $this->title_ar,
            'title_en' => $this->title_en,
            'image'=>get_file($this->image),
        ];
    }
}
