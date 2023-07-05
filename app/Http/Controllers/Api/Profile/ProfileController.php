<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
//use App\Http\Resources\ConsultationsResources;
use App\Http\Resources\PostResources;
use App\Http\Resources\RoomsResources;
use App\Models\Advisor_Category;
use App\Models\Consultations;
use App\Models\Order;
use App\Models\Posts;
use App\Models\PostsActions;
use App\Models\Room;
use App\Models\User;
use Essam\TapPayment\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Paytabscom\Laravel_paytabs\Facades\paypage;


class ProfileController extends Controller{

    public function loveReportFollowPost(Request $request)
    {
        $rules = [
            'post_id' => 'required|exists:posts,id',
            'type' => 'required|in:love,follow,report,save'
        ];
        $validator = Validator::make($request->all(), $rules, [
            'post_id.exists' => 404,
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [
                    404 => 'Failed,post not found',
                ];
                $code = collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }
        $data = $request->only('post_id','type');
        $data['user_id'] = api()->user()->id;
        PostsActions::createOrDelete($data);
        return helperJson(null, 'done');
    }//end fun


    public function requestConsultation(Request $request)
    {
        $rules = [
            'post_id' => 'required|exists:posts,id',
            'adviser_id' => ['required',Rule::exists('users','id')->where('user_type','adviser')],
            'details'=>'required|max:181'
        ];
        $validator = Validator::make($request->all(), $rules, [
            'post_id.exists' => 404,
            'adviser_id .exists' => 406,
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [
                    404 => 'Failed,post not found',
                    406 => 'Failed,adviser not found',
                ];
                $code = collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }


        $data = $validator->valid();
        $data['user_id'] = api()->user()->id;
       $store =  Consultations::create($data);
        $roomCreate['user_id'] = api()->user()->id;
        $roomCreate['adviser_id'] = $request->adviser_id;
        $roomCreate['post_id'] = $request->post_id;
        $roomCreate['consultation_id'] = $store->id;
        Room::create($roomCreate);

       return helperJson(new ConsultationsResources($store));
    }//end fun
    /**
     * @return void
     */
    public function likedPost()
    {
        $IdForPosts = PostsActions::where('user_id', api()->user()->id)->where('type','love')->latest()->pluck('post_id')->toArray();
        $data = Posts::whereIn('id',$IdForPosts)->get();
        return helperJson(PostResources::collection($data));
    }//end fun


    public function savedPost()
    {
        $IdForPosts = PostsActions::where('user_id', api()->user()->id)->where('type','save')->latest()->pluck('post_id')->toArray();
        $data = Posts::whereIn('id',$IdForPosts)->get();
        return helperJson(PostResources::collection($data));
    }//end fun


    public  function  myPosts(){

        $data = Posts::where('user_id',api()->user()->id)->latest()->get();
        return helperJson(PostResources::collection($data));

    }//end fun


    public function addToMyWallet(request $request){

        $rules = [
            'amount' => 'required|numeric|min:1',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'amount.required' => 404,
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [
                    404 => 'please enter a valid amount',
                ];
                $code = collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }



        // شحن المحفظة
//        if ($request->amount > 0) {
//            $TapPay = new Payment(['secret_api_Key' => env('secret_api_Key')]);
//            $redirect = false; // return response as json , you can use it form mobile web view application
//            $payData = $TapPay->charge([
//                'amount' => $request->amount,
//                'currency' => 'SAR',
//                'threeDSecure' => 'true',
//                'description' => "شحن محفظة تطبيق ازدهار",
//                'statement_descriptor' => 'Payment',
//                'customer' => [
//                    'first_name' => api()->user()->first_name,
//                    'email' => (api()->user()->email) ?? 'test@test.com',
//                ],
//                'source' => [
//                    'id' => 'src_card'
//                ],
//                'post' => [
//                    'url' => null
//                ],
//                'redirect' => [
//
//                    'url' => route('checkPaymentOfWallet',api()->user()->id)
//                ]
//            ], $redirect);
//            $data['payData'] = $payData;
//            return helperJson($data, 'تم الوصول الي لينك الدفع');
//        }



        $user = auth('api')->user();
//        dd($user);
        $transaction_type = 'sale';
        $cart_id = self::uniq_id_number();
        $cart_amount = $request->amount;
        $cart_description = 'description';
        $name = 'customer name';
        $email = (isset($user->email)) ? $user->email : 'customer@example.com';
        $phone = $user->phone;
        $street1 = 'street';
        $city = 'EG';
        $state = 'MNF';
        $country = '10';
        $zip = '10111';
        $ip = (isset($_SERVER['HTTP_CLIENT_IP'])) ?  $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
        $same_as_billing = self::uniq_id_number();
        $callback = url('/api/callback_paytabs');
        $return = url('/api/return_paytabs');

        $language = 'en';

        $pay =  paypage::sendPaymentCode('all')
            ->sendTransaction($transaction_type)
            ->sendCart($cart_id,$cart_amount,$cart_description)
            ->sendCustomerDetails($name, $email, $phone, 'street', 'Nasr City', 'Cairo', 'EG', '1234',$ip)
            ->sendShippingDetails($name, $email, $phone, 'street', 'Nasr City', 'Cairo', 'EG', '1234',$ip)
            ->sendURLs($return, $callback)
            ->sendLanguage('en')
            ->create_pay_page();

        $data['payment_url'] = $pay->getTargetUrl();

        return  response()->json(['data' => $data,'message' => 'تم الوصول الي لينك الدفع','code' => 200]);
    }


    public function callback_paytabs(Request $request)
    {
        return $request->status;
    }


    public function return_paytabs(Request $request)
    {
        $tran_ref =  $request->tranRef;
        $str_response =  json_encode(Paypage::queryTransaction($tran_ref));
        $transaction_response  = json_decode($str_response, true);
        $user = User::where('phone',$transaction_response['customer_details']['phone'])->first();
        $payment = \App\Models\Payment::create([
            'tran_ref' => $transaction_response['tran_ref'],
            'reference_no' => $transaction_response['reference_no'],
            'transaction_id' => $transaction_response['transaction_id'],
            'user_id' => $user->id,
            'status' => $transaction_response['success'],
            'cart_amount' => $transaction_response['cart_amount'],
            'tran_currency' => $transaction_response['tran_currency'],
        ]);
        $new_balance = $user->wallet + $transaction_response['cart_amount'];

        $user->update(['wallet' =>$new_balance]);

        return redirect()->to('/api/callback_paytabs?status='.$payment->status);
    }



//    public function checkPaymentOfWallet(request $request)
//    {
//        $TapPay = new Payment(['secret_api_Key' => env('secret_api_Key')]);
//        $data = $TapPay->getCharge($request->tap_id);
//        if ($data->response->code == '000') {
//            $user = User::find($request->user_id);
//            $user->update(['wallet' => $user->wallet + $data->amount]);
//            return Redirect::to('api/order/goThroughUrl/yes/' . $data->id);
//        }
//        return Redirect::to('api/order/goThroughUrl/no/0');
//
//
//    }

    public function deleteProfile(Request $request,$id){

        try {

            $user = User::find($id);
            if(!$user){

                return response()->json(['data' => null,'message' => 'User not found','code' => 404],404);
            }

            $user->delete();
            return response()->json(['message' => 'User deleted successfully','code' => 200],200);

        }catch (\Exception $exception){

            return helperJson(null, $exception->getMessage(),200,200);

        }

    }

}//end class
