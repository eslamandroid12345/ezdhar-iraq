<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\ConsultantTypes;
use App\Models\PostsConsultant;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResources extends JsonResource{

    public function toArray($request)
    {
        $approvedIds = PostsConsultant::where('status','approved')
            ->where('post_id',$this['id'])->pluck('consultant_type_id')->toArray();
        return [


//            'id'=>$this->id,
            'id'=>$this['id'],
            'title'=>$this['title'],
            'text'=>$this['text'],
//            'image'=> get_post_image($this['image'],get_file(Category::find($this['category_id'])->image)),
            'image'=> asset($this->image),
            'date'=>date('Y-m-d',strtotime($this['created_at'])),
            'time'=>date('h:i A',strtotime($this['created_at'])),
            'likes_count'=>$this['likes_count'],
            'is_licked'=>$this['is_licked'],
            'is_followed'=>$this['is_followed'],
            'category_id'=>$this['category_id'],
            'provider_id'=>$this['user_id'],
            'is_reported'=>$this['is_reported'],
            'is_investment'=>$this['is_investment'],
            'category'=>new CategoryResources(Category::find($this['category_id'])),
            'approved_from'=>ConsultantTypeResources::collection(ConsultantTypes::wherein('id',$approvedIds)->latest()->get()),
            'provider'=>new BasicUserResources(User::find($this['user_id']))

        ];
    }
}
