<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'user_id'=>$this->user_id,
            'adviser_id'=>$this->adviser_id,
            'user'=>new BasicUserResources(User::find($this->user_id)),
            'adviser'=>new AdvisersResources(User::find($this->adviser_id)),
            'details'=>$this->details,
            'payment_status'=>$this->payment_status
        ];
    }
}
