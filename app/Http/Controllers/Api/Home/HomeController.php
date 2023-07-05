<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvisersResources;
use App\Http\Resources\CategoryResources;
use App\Http\Resources\SubCategoryResources;
use App\Http\Resources\CityResources;
use App\Http\Resources\ConsultantTypeResources;
use App\Http\Resources\UserResources;
use App\Http\Resources\UserSubResources;
use App\Http\Resources\ProviderResource;
use App\Http\Resources\ProviderOneResources;
use App\Http\Resources\PostResources;
use App\Http\Resources\OneFreelancerResource;
use App\Http\Resources\SliderResources;
use App\Models\Category;
use App\Models\Cities;
use App\Models\Advisor_Category;
use App\Models\ContactUs;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\SubCategory;
use App\Models\ConsultantTypes;
use App\Models\Posts;
use App\Models\Slider;
use App\Models\User;
use Essam\TapPayment\Payment;
use Essam\TapPayment\Tap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $rules = [
            'type' => 'required|in:following,popular',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }
        $data = Posts::latest();

        if (api()->check())
            $data->where('user_id','!=',api()->user()->id);

        if ($request->has('date') && $request->date != 'All')
            $data->whereDate('created_at',date('Y-m-d',strtotime($request->date)));
        if ($request->has('category_id') && $request->category_id != 'All'){
            $rules = [
                'category_id' => 'nullable|exists:categories,id',
            ];
            $validator = Validator::make($request->all(), $rules,[
                'category_id.exists' => 404,
            ]);
            if ($validator->fails()) {
                $errors = collect($validator->errors())->flatten(1)[0];
                if (is_numeric($errors)) {
                    $errors_arr = [
                        404 => 'Failed,Category not found',
                    ];
                    $code = collect($validator->errors())->flatten(1)[0];
                    return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
                }
                return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
            }

            $data->where('category_id',$request->category_id);

        }


        if ($request->type == 'popular')
        {
          $data =  $data->get()->sortByDesc(function($product){
            return $product->likes_count;
        })->toArray();
            $data = array_values($data);
        }elseif($request->type == 'following' && api()->check()){
            $data = $data->Following()->get();
        }else{
            $data = [];
        }
        return response(['data'=>PostResources::collection($data),'message'=>'done','code'=>200],200);
    }//end fun

    public function myNotifications(){
        if (!api()->check())
            return helperJson(null,'يرجي تسجيل الدخول',403);

        $data = Notification::where('user_id',api()->user()->id)->get();
        return helperJson($data,'تم استرجاع الداتا بنجاح',200);
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function typesOfAdvisors()
    {

        $data = ConsultantTypeResources::collection(ConsultantTypes::latest()->get());
        return helperJson($data);
    }//end fun

    public function contact_us(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'subject' => 'required|max:255',
            'message' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'required' => 422,
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [

                    422 => 'يرجي ارسال كل البيانات المطلوبة',
                ];
                $code = collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }

    ContactUs::create([

        'name'     => $request->name,
        'subject'  => $request->subject,
        'email'    => $request->email,
        'message'  => $request->message,
    ]);
        return helperJson(null,'تم ارسال الرسالة للادارة بنجاح',200);
    }


    public function advisorsByType(Request $request)
    {
        $rules = [
            'type_id' => 'required|exists:consultant_types,id'
        ];
        $validator = Validator::make($request->all(), $rules, [
            'type_id.exists' => 404,
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [
                    404 => 'Failed,advisors type not found',
                ];
                $code = collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }
        $data = User::where('consultant_type_id',$request->type_id)->latest()->get();
        return helperJson(AdvisersResources::collection($data));
    }//end fun




    public function providersOfSubCategories(Request $request,$id)
    {
//        $rules = [
//            'sub_category_id' => 'required|exists:sub_categories,id',
//        ];
//        $validator = Validator::make($request->all(), $rules, [
//            'sub_category.exists' => 404,
//        ]);
//        if ($validator->fails()) {
//            $errors = collect($validator->errors())->flatten(1)[0];
//            if (is_numeric($errors)) {
//                $errors_arr = [
//                    404 => 'Failed,sub_category not found',
//                ];
//                $code = collect($validator->errors())->flatten(1)[0];
//                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
//            }
//            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
//        }
//        $ids = Advisor_Category::where([['sub_category_id',$request->sub_category_id]])->pluck('user_id');
//        $data = User::whereIn('id',$ids)->latest()->get();
//
//
//        if($request->sub_category_id != null){
//            $row = Advisor_Category::where('sub_category_id',$request->sub_category_id)->first();
//            foreach ($data as $oneUser){
//                $oneUser['sub_category'] = $row;
//            }
//        }

//        return helperJson(UserResources::collection($data));


        $sub_category = SubCategory::find($id);

       if(!$sub_category){

           return returnMessageError("بيانات الخدمه غير موجوده",500);

       }

        $providers = User::query()->whereHas('advisor_category', function($advisor_category)use($id){

            $advisor_category->with('sub_category')->where('sub_category_id','=',$id);

        })->get();

       if($providers->count() > 0){

           return response()->json(['code' => 200, 'data' => UserSubResources::collection($providers)]);

       }else{

           return response()->json(['code' => 404, 'data' => "لا يوجد مقدمي خدمه تابعين لهذا القسم"]);

       }



    }//end fun



    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories()
    {
        $data = Category::latest()->get();
        return helperJson(CategoryResources::collection($data));
    }//end fun

    public function subCategories(Request $request)
    {
        $rules = [
            'category_id' => 'required|exists:categories,id'
        ];
        $validator = Validator::make($request->all(), $rules, [
            'category_id.exists' => 404,
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [
                    404 => 'Failed,Category not found',
                ];
                $code = collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }

        $data = SubCategory::where('category_id',$request->category_id)->get();
        return helperJson(SubCategoryResources::collection($data));
    }//end fun


    public function oneAdvisor(Request $request)
    {
        $rules = [
            'advisor_id' => 'required|exists:users,id'
        ];
        $validator = Validator::make($request->all(), $rules, [
            'advisor_id.exists' => 404,
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [
                    404 => 'Failed,User type not found',
                ];
                $code = collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }

        $data = User::find($request->advisor_id);
        return helperJson(new AdvisersResources($data));
    }//end fun


    public function oneProvider(Request $request)
    {
        $rules = [
            'provider_id'     => 'required|exists:users,id',
            'sub_category_id' => 'nullable'
        ];
        $validator = Validator::make($request->all(), $rules, [
            'provider_id.exists' => 404,
        ]);
        if ($validator->fails()) {

            $errors = collect($validator->errors())->flatten(1)[0];

            if (is_numeric($errors)) {
                $errors_arr = [

                    404 => 'Failed,User type not found',
                ];
                $code = collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }
        $data = User::find($request->provider_id);


        if($request->sub_category_id != null){

            $row = Advisor_Category::where('sub_category_id',$request->sub_category_id)->first();
            $data['sub_category'] = $row;
        }

//        return helperJson(new ProviderResource($data));
        return helperJson(new OneFreelancerResource($data));
    }//end fun


    public function cities()
    {
        $data = Cities::all();
        return helperJson(CityResources::collection($data));
    }//end fun

    public function slider()
    {
        $data = Slider::latest()->get();
        return helperJson(SliderResources::collection($data));
    }//end fun

    public function investmentProjects()
    {
        $data = Posts::where('is_investment',true)->latest()->get();
        return helperJson(PostResources::collection($data));
    }

    public function setting(){
        $data = Setting::first();
        return helperJson($data);
    }

}//end class
