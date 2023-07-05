<?php

namespace App\Http\Resources;

use App\Models\Posts;
use App\Models\RoomMessages;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomsResources extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'adviser_id'=>$this->adviser_id,
            'sub_category_id'=>(int)$this->sub_category_id,
            'post_id'=>$this->post_id,
            'is_end'=> (string)$this->is_end,
            'user'=>new BasicUserResources(User::find($this->user_id)),
            'provider'=>new BasicUserResources(User::find($this->adviser_or_freelancer_id)),
            'messages'=> ChatResources::collection(RoomMessages::where('room_id', $this->id)->get()),
            'services'=> ServiceRequestResources::collection(ServiceRequest::where('room_id', $this->id)->where('status','=','new')->get()),
            'latest_message'=>new ChatResources(RoomMessages::where('room_id', $this->id)->latest()->first()),
        ];
    }
}
