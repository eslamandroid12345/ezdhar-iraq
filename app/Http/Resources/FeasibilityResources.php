<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeasibilityResources extends JsonResource
{

    public function toArray($request)
    {
        return [

            'id' => $this->id,
            'project_name' => $this->project_name,
            'ownership_rate' => $this->ownership_rate,
            'note' => $this->note,
            'details'  => $this->details,
            'show' => $this->show,
            'img' =>  asset('feasibilities/' . $this->img),
            'user' => new UserResources($this->user),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),


        ];
    }
}
