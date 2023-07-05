<?php

namespace App\Http\Controllers\Api\FreelancerSubCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Advisor_Category;
use App\Http\Resources\FreelancerSubCategoryResources;
use App\Http\Controllers\Controller;


class ServiceController extends Controller{


    public function store(Request $request){

        try {


            $rules = [

                'sub_category_id' => 'required|exists:sub_categories,id',
                'desc_ar' => 'required',
                'desc_en' => 'required',
                'price' => 'required|integer|not_in:0',

            ];


            $messages = [

                'sub_category_id.required' => __("service.sub_category_id"),
                'sub_category_id.exists' => __("service.sub_category_id_exists"),
                'desc_ar.required' => __("service.des_ar"),
                'desc_en.required' => __("service.des_en"),
                'price.required' => __("service.price"),
                'price.integer' => __("service.price_integer"),
                'price.not_in' => __("service.price_not_in"),



            ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if ($validator->fails()){

                return returnMessageError($validator->errors(),500);
            }


            $freelancer_category = new Advisor_Category();
            $freelancer_category->sub_category_id = $request->sub_category_id;
            $freelancer_category->user_id = auth('api')->id();
            $freelancer_category->desc_ar = $request->desc_ar;
            $freelancer_category->desc_en = $request->desc_en;
            $freelancer_category->price = $request->price;
            $freelancer_category->save();


            if(isset($freelancer_category)){


                return returnDataSuccess(__("service.message"),200,"service",new  FreelancerSubCategoryResources($freelancer_category));

            }

        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),500);

        }


    }


    public function update(Request $request){


        try {


            $rules = [

                'desc_ar' => 'required',
                'desc_en' => 'required',
                'price' => 'required|integer|not_in:0',

            ];


            $messages = [

                'desc_ar.required' => __("service.des_ar"),
                'desc_en.required' => __("service.des_en"),
                'price.required' => __("service.price"),
                'price.integer' => __("service.price_integer"),
                'price.not_in' => __("service.price_not_in"),



            ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if ($validator->fails()){

                return returnMessageError($validator->errors(),500);
            }


            $freelancer_category = Advisor_Category::find($request->id);

            if(!$freelancer_category){

                return returnMessageError("service not found",404);

            }
            $freelancer_category->desc_ar = $request->desc_ar;
            $freelancer_category->desc_en = $request->desc_en;
            $freelancer_category->price = $request->price;
            $freelancer_category->save();


            if(isset($freelancer_category)){


                return returnDataSuccess(__("service.update"),200,"service",new  FreelancerSubCategoryResources($freelancer_category));

            }

        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),500);

        }


    }

    public function delete($id){

        try {

            $freelancer_category = Advisor_Category::find($id);

            if(!$freelancer_category){

                return returnMessageError("service not found",404);

            }

            $freelancer_category->delete();

            return returnMessageError("Service of provider deleted successfully",200);


        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),500);

        }

    }


}
