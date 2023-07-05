<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RateResources extends JsonResource
{

    public function toArray($request)
    {
        return [

            'id'=>$this->id,
            'rate_number' => $this->rate_number,
            'details' => $this->details,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => $this->user,
            'provider' => $this->provider,


        ];
    }
}
