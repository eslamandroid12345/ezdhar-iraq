<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class OrderResourses extends JsonResource
{

    public function toArray($request)
    {
        return [

            'id' => $this->id,
            'status' => $this->status,
            'details' => $this->note,
            'img' => URL::to('/orders/' . $this->img),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),
            'sub_category' => new SubCategoryResources($this->sub_category),
            'user' => new UserResources($this->user),



        ];
    }
}
