<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceRequestResources extends JsonResource
{

    public function toArray($request)
    {
        return [

            'id'=> $this->id,
            'price' => number_format($this->price,2),
            'details' => $this->details,
            'delivery_date'=> $this->delivery_date,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
            'sub_category' => new SubCategoryResources($this->sub_category),
            'user_id' => $this->user_id,
            'provider_id' => $this->provider_id,
            'room_id' => $this->room_id,
            'status' => $this->status,
            'user' => new UserResources($this->user),
            'provider' =>  new UserResources($this->provider),

        ];
    }
}
