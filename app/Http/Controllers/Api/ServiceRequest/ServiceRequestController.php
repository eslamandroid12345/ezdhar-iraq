<?php

namespace App\Http\Controllers\Api\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ServiceRequest;
use App\Http\Resources\ServiceRequestResources;
use App\Http\Controllers\Controller;
use App\Traits\NotificationTrait;



class ServiceRequestController extends Controller{

    use NotificationTrait;

    public function index(){

        try {

            $service_requests = ServiceRequest::query()->get();

            return returnDataSuccess("تم الحصول علي طلبات مقدمي الخدمه بنجاح", 200, "service_requests",ServiceRequestResources::collection($service_requests));

        } catch (\Exception $exception) {

            return returnMessageError($exception->getMessage(), 500);


        }
    }


    public function store(Request $request){

        try {


            $rules = [

                'sub_category_id' => 'required|exists:sub_categories,id',
                'user_id'         => 'required|exists:users,id',
                'delivery_date'   => 'required|date',
                'details'         => 'required',
                'price'           => 'required|integer|not_in:0',
                'room_id'         => 'required|integer|exists:rooms,id',

            ];


            $messages = [

                'sub_category_id.required' => "يرجي ادخال رقم الخدمه",
                'sub_category_id.exists'   => "هذه الخدمه غير موجوده بسجل البيانات",
                'user_id.required'         => "يرجي ادخال رقم العميل",
                'user_id.exists'           => "هذا العميل غير موجود بسجل البيانات",
                'details.required'         => "تفاصيل طلب العميل مطلوبه",
                'price.required'           => "سعر الخدمه مطلوب",
                'price.integer'            => "سعر الخدمه يجب ان يحتوي علي ارقام فقط",
                'price.not_in'             => "سعر الخدمه يجب ان لا يكون 0",
                'delivery_date.required'   => 'يرجي ادخال ميعاد استلام طلب العميل',
                'delivery_date.date'       => 'موعد استلام طلب العميل يجب ان يكون تاريخ',
                'room_id.required'         => 'رقم الغرفه مطلوب',
                'room_id.exists'         => 'غرفه الشات غير موجوده',
                'room_id.integer'          => 'رقم الغرفه يجب ان يكون رقم',

            ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if ($validator->fails()){

                return returnMessageError($validator->errors(),500);
            }


            $service = ServiceRequest::create([

                'provider_id' => auth('api')->id(),
                'user_id' =>  $request->user_id,
                'sub_category_id' => $request->sub_category_id,
                'details' => $request->details,
                'price' => $request->price,
                'delivery_date' => $request->delivery_date,
                'room_id' => $request->room_id,
            ]);


            if(isset($service)){

                $this->sendChatNotification('يوجد طلب جديد لديك' ,$request->user_id);

                return returnDataSuccess("تم رفع الطلب للادمن بنجاح",200,"service_request",new  ServiceRequestResources($service));

            }

        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),500);

        }


    }


    public function changeStatus(Request $request,$id){

        try {


            $rules = ['status' => 'required|in:completed,refused,accepted'];


            $messages = [
                'status.required' => 'حاله الطلب مطلوبه',
                'status.in' => 'حاله الطلب يجب ان تكون ما بين [completed,refused,accepted]',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {

                return returnMessageError($validator->errors(), 500);
            }

            $service = ServiceRequest::find($id);

            if(!$service){

                return returnMessageError("الطلب غير موجود بسجل البيانات",404);

            }


            if(auth('api')->id() == $service->user_id){

                $service->update([

                    'status' => $request->status
                ]);

            if($request->status == 'accepted') {

                if(auth('api')->user()->wallet < $service->price){

                    return returnMessageError('عفوا الرصيد المتاح في المحفظة هو '. auth('api')->user()->wallet,407);


                }else{

                    auth('api')->user()->update([

                        'wallet' => (auth('api')->user()->wallet - $service->price)

                    ]);

                    $this->sendBasicNotification("رساله جديده","تمت الموافقه علي طلبك بنجاح",$service->provider_id,null,"service_request");


                    return returnMessageSuccess("تمت الموافقه علي طلبك بنجاح وتم خصم مبلغ " .  $service->price, 200);

                }

              } elseif($request->status == 'refused') {


                $this->sendBasicNotification("رساله جديده","تم رفض طلبك بنجاح",$service->provider_id,null,"service_request");

               return returnMessageSuccess("تم رفض طلبك بنجاح", 201);


               }else{


                $this->sendBasicNotification("رساله جديده","تم اكتمال طلبك بنجاح",$service->provider_id,null,"service_request");

              return returnMessageSuccess("تم اكتمال طلبك بنجاح", 201);
              }

            }else{

                return returnMessageError("غير مصرح لك بقبول هذا الطلب",403);

            }


        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),500);

        }


    }


    public function userServiceAccepted(){

        try {

            $service_requests = ServiceRequest::query()->where('user_id','=',auth('api')->id())->where('status','=','accepted')->get();

            return returnDataSuccess("تم الحصول علي طلبات العميل المقبوله بنجاح", 200, "service_requests",ServiceRequestResources::collection($service_requests));

        } catch (\Exception $exception) {

            return returnMessageError($exception->getMessage(), 500);


        }

    }

    public function userServiceCompleted(){

        try {

            $service_requests = ServiceRequest::query()->where('user_id','=',auth('api')->id())->where('status','=','completed')->get();

            return returnDataSuccess("تم الحصول علي طلبات العميل المكتمله بنجاح", 200, "service_requests",ServiceRequestResources::collection($service_requests));

        } catch (\Exception $exception) {

            return returnMessageError($exception->getMessage(), 500);


        }

    }


    public function providerServiceAccepted(){

        try {

            $service_requests = ServiceRequest::query()->where('provider_id','=',auth('api')->id())->where('status','=','accepted')->get();

            return returnDataSuccess("تم الحصول علي طلبات مقدم الخدمه المقبوله بنجاح", 200, "service_requests",ServiceRequestResources::collection($service_requests));

        } catch (\Exception $exception) {

            return returnMessageError($exception->getMessage(), 500);


        }

    }

    public function providerServiceCompleted(){

        try {

            $service_requests = ServiceRequest::query()->where('provider_id','=',auth('api')->id())->where('status','=','completed')->get();

            return returnDataSuccess("تم الحصول علي طلبات مقدم الخدمه المكتمله بنجاح", 200, "service_requests",ServiceRequestResources::collection($service_requests));

        } catch (\Exception $exception) {

            return returnMessageError($exception->getMessage(), 500);


        }


    }


    public function details($id){

        try {

            $service_request = ServiceRequest::find($id);

            if(!$service_request){

                return returnMessageError("هذا الطلب غير موجود", 404);

            }

            return returnDataSuccess("تم الحصول علي بيانات الطلب بنجاح", 200, "service",new ServiceRequestResources($service_request));

        } catch (\Exception $exception) {

            return returnMessageError($exception->getMessage(), 500);


        }
    }

}
