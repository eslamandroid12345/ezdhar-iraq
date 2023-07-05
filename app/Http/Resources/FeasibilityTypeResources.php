<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeasibilityTypeResources extends JsonResource
{

    public function toArray($request)
    {
        return [

            'id' => $this->id,
            'type' => $this->type,
            'img' =>  asset('feasibilities/' . $this->img),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),


        ];
    }
}
