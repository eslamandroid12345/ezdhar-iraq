<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use App\Models\PostProviderAction;

class PostProviderMakeLoveResource extends JsonResource{

    public function toArray($request){


        return [

            'id' => $this->id,
            'description' => $this->description,
            'status' => $this->status,
            'action_user' => 'love',
            'img' => URL::to('/jobs/' . $this->image),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),
            'provider' => new UserResources($this->provider),

        ];
    }
}
