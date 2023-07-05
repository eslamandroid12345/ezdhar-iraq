<?php

namespace App\Http\Controllers\Api\Provider;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProviderResource;
use App\Models\Advisor_Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProviderController extends Controller
{
    public function statistics(){
        $data['client_month'] = Order::where('advisor_or_user_id',api()->user()->id)
            ->whereMonth('created_at', date('m'))->count();

        $data['orders'] = Order::whereMonth('created_at', date('m'))->count();

        $data['client_year'] = Order::where('advisor_or_user_id',api()->user()->id)
            ->whereYear('created_at', date('Y'))->count();

        $data['miss_orders'] = Order::whereMonth('created_at', date('m'))
            ->where('status','!=','accepted')->where('advisor_or_user_id',api()->user()->id)->count();

        return helperJson($data,'GOOD');
    }

    public function myOrders(){
        $data = Order::where('advisor_or_user_id',api()->user()->id)->latest()->get();
        return helperJson($data,'تم');
    }

    public function controlMyCategories(request $request){
        $rules = [
            'category_id'                    => 'required|exists:categories,id',
            'sub_category_object'            => 'nullable|array',
            'sub_category_object.*.sub_category_id'    => ["nullable",Rule::exists('sub_categories','id')
                ->where('category_id',$request->category_id)],
            'sub_category_object.*.price'         => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'sub_category_object.*.desc_ar' => 'nullable',
            'sub_category_object.*.desc_en' => 'nullable',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'exists' => 404,
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [
                    404 => 'خطأ يرجي التأكد من البيانات المرسلة للكاتيجوري والصب كاتيجوري',
                ];
                $code = collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }

        api()->user()->update([
            'category_id' => $request->category_id
        ]);


        // لو غير القسم الرئيسي المشترك فيه وقف الاقسام الفرعية اللي كان مشترك فيها
        if($request->category_id != api()->user()->category_id) {
            $oldData = Advisor_Category::where('user_id', api()->user()->id)->get();
            foreach ($oldData as $row) {
                $row->delete();
            }
        }


        // لو هيغير الاقسام الفرعية له نسمح الاقسام الفرعية اللي كان مشترك فيها ونضيف من جديد
        if($request->has('sub_category_object') && $request->sub_category_object != null){
           $oldData = Advisor_Category::where('user_id',api()->user()->id)->get();
           foreach ($oldData as $row){
               $row->delete();
           }

           foreach ($request->sub_category_object as $input){
               Advisor_Category::create([
                  'user_id' => api()->user()->id,
                  'sub_category_id' => $input['sub_category_id'],
                   'desc_ar' => $input['desc_ar'],
                   'desc_en' => $input['desc_en'],
                   'price' => $input['price'],
                   'status' => 'new',
               ]);
           }

           return helperJson(new ProviderResource(api()->user()),'تم التعديل بنجاح',200);
        }


    }




}
