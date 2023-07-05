<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubCategory;
use App\Models\ConsultantTypes;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'orders';

    protected $fillable = [

        'user_id',
        'advisor_or_user_id',
        'sub_category_id',
        'status',
        'note',
        'payment_status',
        'img',
    ];




    ###### Relation #######

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function advisor_or_user(){
        return $this->belongsTo(User::class,'advisor_or_user_id');
    }

    public function sub_category(){
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }

    public function consultation_type(){
        return $this->belongsTo(ConsultantTypes::class,'consultation_type_id');
    }


}
