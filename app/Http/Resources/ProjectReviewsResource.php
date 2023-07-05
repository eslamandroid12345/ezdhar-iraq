<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Project;
use App\Models\SubCategory;
use App\Http\Resources\SubCategoryResources;
use App\Http\Resources\BasicUserResources;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectReviewsResource extends JsonResource
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
            'id'=>$this['id'],
            'sub_category_id'=>$this['sub_category_id'],
            'user_id'=>$this['user_id'],
            'project_id'=>$this['project_id'],
            'rate'=>$this['rate'],
            'report'=>$this['report'],
            'date'=>date('Y-m-d',strtotime($this['created_at'])),
            'time'=>date('h:i A',strtotime($this['created_at'])),
            'project'=>new ProjectResource(Project::find($this['sub_category_id'])),
            'sub_category'=>new SubCategoryResources(SubCategory::find($this['sub_category_id'])),
            'user'=>new BasicUserResources(User::find($this['user_id']))
        ];
    }
}
