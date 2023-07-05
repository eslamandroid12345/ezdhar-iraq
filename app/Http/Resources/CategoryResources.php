<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResources extends JsonResource
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
        'title_ar'=>$this->title_ar,
        'title_en'=>$this->title_en,
        'limit' =>$this->limit,
        'image'=>get_file($this->image),
    ];
    }
}
