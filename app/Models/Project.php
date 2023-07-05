<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectReview;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function reviews(){
        return $this->hasMany(ProjectReview::class,'project_id');
    }
}
