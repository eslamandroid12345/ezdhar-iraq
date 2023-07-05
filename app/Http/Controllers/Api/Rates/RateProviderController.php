<?php

namespace App\Http\Controllers\Api\Rates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Rate;
use App\Http\Resources\RateResources;
use App\Http\Controllers\Controller;


class RateProviderController extends Controller{


    public function index(){


        try {

            $rates = Rate::query()->latest()->get();

            return returnDataSuccess("تم الحصول علي جميع تقيمات مقدمي الخدمه بنجاح", 200, "rates",RateResources::collection($rates));

        } catch (\Exception $exception) {

            return returnMessageError($exception->getMessage(), 500);


        }
    }


    public function store(Request $request){

        try {


            $rules = [

                'rate_number'=> 'required|integer',
                'details'=> 'required',
                'provider_id'=> 'required|exists:users,id',

            ];


            $messages = [

                'rate_number.required' => 'يرجي تقييم مقدم الخدمه',
                'rate_number.integer' => 'يجب ان يكون تقييم مقدم الخدمه رقم صحيح',
                'details.required' => 'اوصف تعاملك مع مقدم الخدمه',
                'provider_id.required' => 'يرجي ادخال رقم مقدم الخدمه',
                'provider_id.exists' => 'رقم مقدم الخدمه غير موجود بسجل البيانات',


            ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if ($validator->fails()){

                return returnMessageError($validator->errors(),500);
            }

            $rate = Rate::create([

                'rate_number'=> $request->rate_number,
                'details'=> $request->details,
                'user_id'=> auth('api')->id(),
                'provider_id'=> $request->provider_id,

            ]);

            if(isset($rate)){

                return returnDataSuccess("تم رفع تقييم مقدم الخدمه للادمن بنجاح",200,"rate",new RateResources($rate));

            }

        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),500);

        }


    }


    public function delete($id){

        try {

            $rate = Rate::find($id);

            if(!$rate)
                return returnMessageError("هذا التقيم غير موجود بسجل البيانات",500);
             else
                 $rate->delete();

            return returnMessageError("تم حذف التقييم بنجاح",200);



        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),500);

        }


    }





}
