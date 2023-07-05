<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomsResources;
use App\Models\Advisor_Category;
use App\Models\Order;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Essam\TapPayment\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\OrderResourses;
use App\Traits\NotificationTrait;


class OrderController extends Controller
{
    use NotificationTrait;

    public function makeOrderFromProvider(request $request)
    {
        $rules = [

            'provider_id'     => 'required|exists:users,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'note'            => 'nullable',
            'img'             => 'nullable',

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
        if (!api()->check())
            return helperJson(null, 'يرجي تسجيل الدخول', 403);


//        // Get Price Of The Provider Service
//        $service = Advisor_Category::where([['user_id', $request->provider_id], ['sub_category_id', $request->sub_category_id]])->first();
//
//        if (!$service)
//            return helperJson(null, 'يرجي التأكد من بيانات الخدمة ومقدم الخدمة', 405);


//        // اذا كانت الخدمة مدفوعة فيجب ان يتم التحويل الي الدفع اولا
//        if ($service->price != 0 && $service->price != null) {
//            $TapPay = new Payment(['secret_api_Key' => env('secret_api_Key')]);
//            $redirect = false; // return response as json , you can use it form mobile web view application
//            $payData = $TapPay->charge([
//                'amount' => $service->price,
//                'currency' => 'SAR',
//                'threeDSecure' => 'true',
//                'description' => $service->sub_category->title_ar . ' ' . $service->sub_category->title_en,
//                'statement_descriptor' => 'Payment',
//                'customer' => [
//                    'first_name' => api()->user()->first_name,
//                    'email' => api()->user()->email,
//                ],
//                'source' => [
//                    'id' => 'src_card'
//                ],
//                'post' => [
//                    'url' => null
//                ],
//                'redirect' => [
//
//                    'url' => route('checkPaymentOfProvider')
//                ]
//            ], $redirect);
//            $order = Order::create([
//                'transaction_id' => $payData->id,
//                'user_id' => api()->user()->id,
//                'advisor_or_user_id' => $request->provider_id,
//                'sub_category_id' => $request->sub_category_id,
//                'status' => 'accepted',
//                'note' => $request->note,
//            ]);
//            $data['payData'] = $payData;
//            $data['order'] = $order;
//            $data['room'] = null;
//            return helperJson($data, 'تم الوصول الي لينك الدفع');
//        }
//        else{
//            $rand  = 'chg_TS'.rand(100,999999999999);
//            $order = Order::create([
//                'transaction_id' => $rand,
//                'user_id' => api()->user()->id,
//                'advisor_or_user_id' => $request->provider_id,
//                'sub_category_id' => $request->sub_category_id,
//                'status' => 'accepted',
//                'note' => $request->note,
//                'payment_status' => 'paid'
//            ]);
//            $room = Room::create([
//                'user_id' => $order->user_id,
//                'adviser_or_freelancer_id' => $order->advisor_or_user_id,
//                'sub_category_id' => $order->sub_category_id,
//                'is_end' => 0,
//            ]);
//            $data['payData'] = null;
//            $data['order'] = $order;
//            $data['room'] = new RoomsResources($room);
//            return helperJson($data, 'خدمة مجانية تم بنجاح');
//        }

        // يتم دفع 10 ريال لبدأ المحادثة
        if(api()->user()->wallet >= 10){

//
//            if ($image = $request->file('img')) {
//
//                $destinationPath = 'orders/';
//                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
//                $image->move($destinationPath, $profileImage);
//                $request['img'] = "$profileImage";
//            }

            $data['user_id'] = api()->user()->id;
            $data['advisor_or_user_id'] =  (int)$request->provider_id;
            $data['sub_category_id'] = (int)$request->sub_category_id;
            $data['status'] = 'new';
            $data['note'] = $request->note;
            $data['payment_status'] = 'paid';

            $order = Order::create($data);


            $chat = Room::where('adviser_or_freelancer_id','=', $order->advisor_or_user_id)->where('user_id','=',$order->user_id)->first();

            if(!$chat){

                $chat = Room::create([

                    'user_id' => api()->user()->id,
                    'adviser_or_freelancer_id' => $request->provider_id,
                    'sub_category_id' => $request->sub_category_id,
                    'is_end' => 0,
                ]);

                api()->user()->update([

                    'wallet' => api()->user()->wallet - 10
                ]);

                $this->sendBasicNotification("رساله جديده","يوجد طلب جديد",$request->provider_id,$chat->id,"chat");

                return returnDataSuccess("تم خصم مبلغ 10 ريال من المحفظة لبدأ المحادثة",200,"room",new RoomsResources($chat));

            }

            api()->user()->update([

                'wallet' => api()->user()->wallet - 10
            ]);

            $this->sendBasicNotification("رساله جديده","يوجد طلب جديد لديك",$request->provider_id,$chat->id,"chat");

            return returnDataSuccess("تم خصم مبلغ 10 ريال من المحفظة لبدأ المحادثة",200,"room",new RoomsResources($chat));
        }
        else
            return helperJson(null, 'عفوا الرصيد المتاح في المحفظة هو '.api()->user()->wallet,407);

    }

    public function checkPaymentOfProvider(request $request)
    {
        $TapPay = new Payment(['secret_api_Key' => env('secret_api_Key')]);
        $data = $TapPay->getCharge($request->tap_id);
        if ($data->response->code == '000') {
            $order = Order::where('transaction_id', $request->tap_id)->first();
            $order->update(['payment_status' => 'paid']);
            $data = Room::create([

                'user_id' => $order->user_id,
                'adviser_or_freelancer_id' => $order->advisor_or_user_id,
                'sub_category_id' => $order->sub_category_id,
                'is_end' => 0,
            ]);
            return Redirect::to('api/order/goThroughUrl/yes/' . $data->id);
        }
        return Redirect::to('api/order/goThroughUrl/no/0');
    }

    public function goThroughUrl($status)
    {
        return $status;
    }


    public function home(){


        $orders = Order::where('advisor_or_user_id','=',auth('api')->id())->count();

        $orders_month = Order::where('advisor_or_user_id','=',auth('api')->id())
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))->count();


        $users = User::query()->select('id','first_name')->whereHas('orders', function ($order){

            $order->where('advisor_or_user_id','=',auth('api')->id());
        })->with(['orders' => function($order){

            $order->select('id','user_id','advisor_or_user_id');

        }])->count();

        $users_month = User::query()->select('id','first_name')->whereHas('orders', function ($order){

            $order->where('advisor_or_user_id','=',auth('api')->id());

        })->with(['orders' => function($order){

            $order->select('id','user_id','advisor_or_user_id')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));

        }])->count();


        return returnDataSuccess("تم الحصول علي الاوردرات بنجاح",200,"orders",[

            "orders" => $orders,
            "orders_month" => $orders_month,
            "total_users" => $users,
            "users_month" => $users_month
        ]);

    }


      public function new(){

        $orders_new = Order::query()->latest()->where('advisor_or_user_id','=',auth('api')->id())
            ->where('status','=','new')->get();

        if ($orders_new->count() > 0)

          return returnDataSuccess("تم الحصول علي جميع الاوردرات الجديده",200,"orders",OrderResourses::collection($orders_new));

          else
              return returnMessageError("لا يوجد اي طلبات جديده",500);


      }

    public function accepted(){


        $orders_accepted = Order::query()
            ->where('advisor_or_user_id','=',auth('api')->id())
            ->where('status','=','accepted')->get();

        if($orders_accepted->count() > 0)

        return returnDataSuccess("تم الحصول علي جميع الاوردرات المقبوله",200,"orders",OrderResourses::collection($orders_accepted));
        else
            return returnMessageError("لا يوجد اي طلبات مقبوله",500);

    }


    public function refused(){

        $orders_refused =Order::query()
            ->where('advisor_or_user_id','=',auth('api')->id())
            ->where('status','=','refused')->get();

        if($orders_refused->count() > 0)

        return returnDataSuccess("تم الحصول علي جميع الاوردرات المرفوضه بنجاح",200,"orders",OrderResourses::collection($orders_refused));
        else
            return returnMessageError("لا يوجد اي طلبات مرفوضه الي الان",500);

    }


    public function completed(){

        $orders_completed = Order::query()
            ->where('advisor_or_user_id','=',auth('api')->id())
            ->where('status','=','completed')->get();

        if($orders_completed->count() > 0)

        return returnDataSuccess("تم الحصول علي جميع الاوردرات المقبوله",200,"orders",OrderResourses::collection($orders_completed));

        else
            return returnMessageError("لا يوجد اي طلبات مكتمله حاليا",500);

    }


    public function changeStatus(Request $request){

        try {

            $rules = [

                'id' => 'required',
                'status' => 'required|in:accepted,refused,completed'
            ];


            $messages = [

                'id.required' => 'يرجي ادخال رقم الطلب',
                'status.required' => 'يرجي ادخال حاله الطلب',
                'status.in' => 'حاله الطلب يجب ان تكون ["completed","refused","accepted"]'

            ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if ($validator->fails()){

                return returnMessageError($validator->errors(),500);
            }

            $order = Order::find($request->id);

            //count of orders provider accepted
            $limit = Order::query()->where('advisor_or_user_id','=',auth('api')->id())->where('status','=','accepted')->count();

            if(!$order){

                return returnMessageError("هذا الطلب غير موجود بسجل البيانات",404);

            }

            if($request->status == "accepted" && $limit < $order->sub_category->category->limit){

                $order->status = $request->status;
                $order->save();

            } elseif ($request->status == "refused" || $request->status == "completed"){

                $order->status = $request->status;
                $order->save();
            }
            else{

                return returnMessageError($order->sub_category->category->limit . "غير مصرح لك بتعديل اكثر من ",500);

            }

            return returnDataSuccess( "تم تعديل هذا الطلب بنجاح ",200,"order",$order);

        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),500);

        }

    }




}
