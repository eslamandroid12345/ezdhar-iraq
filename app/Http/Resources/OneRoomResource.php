<?php

namespace App\Http\Resources;

use App\Http\Resources\BasicUserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class OneRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'adviser_id'=>$this->adviser_id,
            'sub_category_id'=>$this->sub_category_id,
            'post_id'=>$this->post_id,
            'is_end'=>$this->is_end,
            'user'=>new BasicUserResources(User::find($this->user_id)),
            'provider'=>new BasicUserResources(User::find($this->adviser_or_freelancer_id)),
        ];
    }
}
