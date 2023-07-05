<?php

namespace App\Http\Controllers\Api\OrderReport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\OrderReportResources;
use App\Models\OrderReport;


class OrderReportController extends Controller{


    public function storeReportByUser(Request $request){


        try {

            $rules = [

                'reason' =>'required',
                'details' =>'required',
                'img' => 'image',
                'order_id' =>'required|exists:service_requests,id',
                'provider_id' =>'required|exists:users,id',


            ];


            $messages = [

                'reason.required' =>'اكتب وصف المشكله',
                'details.required' =>'تفاصيل المشكله بالتحديد مطلوبه',
                'img.image' => 'الصوره المرفقه يجب ان تكون صوره',
                'order_id.required' =>'رقم الطلب مطلوب',
                'provider_id.required' =>'رقم مقدم الخدمه مطلوب',
                'order_id.exists' =>'رقم الطلب غير موجود',
                'provider_id.exists' =>'رقم مقدم الخدمه غير موجود',

            ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if ($validator->fails()){

                return returnMessageError($validator->errors(),500);
            }

            if ($image = $request->file('img')) {

                $destinationPath = 'problems/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $request['img'] = "$profileImage";
            }

            $order_report = OrderReport::create([

                'reason' => $request->reason,
                'details' => $request->details,
                'order_id' => $request->order_id,
                'provider_id' => $request->provider_id,
                'user_id' => auth('api')->id(),


            ]);


            if(!is_null($order_report)){
                return returnDataSuccess("تم رفع الشكوي في مقدم الخدمه بنجاح",200,"order_report",new OrderReportResources($order_report));


            }

        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),500);

        }
    }



    public function storeReportByProvider(Request $request){


        try {

            $rules = [

                'reason' =>'required',
                'details' =>'required',
                'img' => 'image',
                'order_id' =>'required|exists:service_requests,id',
                'user_id' =>'required|exists:users,id',


            ];


            $messages = [

                'reason.required' =>'اكتب وصف المشكله',
                'details.required' =>'تفاصيل المشكله بالتحديد مطلوبه',
                'img.image' => 'الصوره المرفقه يجب ان تكون صوره',
                'order_id.required' =>'رقم الطلب مطلوب',
                'user_id.required' =>'رقم العميل مطلوب',
                'order_id.exists' =>'رقم الطلب غير موجود',
                'user_id.exists' =>'رقم العميل الخدمه غير موجود',

            ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if ($validator->fails()){

                return returnMessageError($validator->errors(),500);
            }

            if ($image = $request->file('img')) {

                $destinationPath = 'problems/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $request['img'] = "$profileImage";
            }

            $order_report = OrderReport::create([

                'reason' => $request->reason,
                'details' => $request->details,
                'order_id' => $request->order_id,
                'provider_id' => auth('api')->id(),
                'user_id' => $request->user_id,


            ]);


            if(!is_null($order_report)){
                return returnDataSuccess("تم رفع الشكوي في العميل بنجاح",200,"order_report",new OrderReportResources($order_report));


            }

        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),500);

        }
    }



}
