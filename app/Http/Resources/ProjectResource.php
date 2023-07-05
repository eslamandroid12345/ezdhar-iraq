<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Category;
use App\Models\ProjectReview;
use App\Http\Resources\ProjectReviewsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=>$this['id'],
            'title'=> lang() == 'ar' ? $this['title_ar'] : $this['title_en'],
            'text'=> lang() == 'ar' ? $this['text_ar'] : $this['text_en'],
            'image'=>get_post_image($this['image'],get_file(Category::find($this['category_id'])->image)),
            'date'=>date('Y-m-d',strtotime($this['created_at'])),
            'time'=>date('h:i A',strtotime($this['created_at'])),
            'category_id'=>$this['category_id'],
            'user_id'=>$this['user_id'],
            'is_investment'=>$this['is_investment'] ?? '0',
            'category'=>new CategoryResources(Category::find($this['category_id'])),
            'reviews_list'=>ProjectReviewsResource::collection(ProjectReview::where('project_id',$this['id'])->latest()->get()),
            'user'=>new BasicUserResources(User::find($this['user_id']))
        ];
    }
}
