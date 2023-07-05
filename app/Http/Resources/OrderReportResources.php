<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\Types\Null_;

class OrderReportResources extends JsonResource
{

    public function toArray($request)
    {
        return [

            'id'=> $this->id,
            'reason' => $this->reason,
            'details' => $this->details,
            'img' => $this->img != NULL ?asset('/problems/'. $this->img) : 'لا يوجد سجل مرفق',
            'user_id' => $this->user_id,
            'provider_id' => $this->provider_id,
            'order_id' => $this->order_id,
            'created_at'=> $this->created_at->format('Y-m-d'),
            'updated_at'=> $this->updated_at->format('Y-m-d'),


        ];
    }
}
