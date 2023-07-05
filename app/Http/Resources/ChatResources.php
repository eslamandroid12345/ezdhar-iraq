<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResources extends JsonResource{

    public function toArray($request)
    {
        return [

            'type'=>$this->type,
            'message'=>$this->message,
            'file'=> $this->file != NULL ? asset('chats/' . $this->file) : 'لا يوجد سجل مرفق',
            'from_user_id'=>$this->from_user_id,
            'to_user_id'=>$this->to_user_id,
            'from_user'=>new BasicUserResources(User::find($this->from_user_id)),
            'to_user'=>new BasicUserResources(User::find($this->to_user_id)),
            'date'=>date('Y-m-d',strtotime($this->created_at)),
            'time'=>date('h:i A',strtotime($this->created_at)),
        ];
    }
}
