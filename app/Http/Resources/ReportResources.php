<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportResources extends JsonResource
{

    public function toArray($request)
    {
        return [

            'id'=>$this->id,
            'reason' => $this->reason,
            'details' => $this->details,
            'photo' => $this->photo == NULL ?  'لا يوجد مرفق لعرضه' : asset('/reports/' . $this->photo),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => $this->user,
            'provider' => $this->provider,


        ];
    }
}
