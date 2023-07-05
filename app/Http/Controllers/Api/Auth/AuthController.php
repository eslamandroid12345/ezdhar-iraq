<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Traits\DefaultImage;
use App\Models\User;
use App\Models\ServiceRequest;
use App\Models\PhoneTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Resources\{AdvisersResources, ProviderResource, UserResources,ServiceRequestResources};

class AuthController extends Controller
{
    use DefaultImage;

    public function __construct()
    {
        $this->middleware('jwt')->only('logout', 'getProfile', 'insert_token', 'updateProfile');
    }//end fun

    public function login(Request $request)
    {
        $rules = [
            'phone_code' => 'required',
            'phone'      => 'required|exists:users,phone',
            'user_type'  => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, [

            'phone.exists' => 406,
        ]);

        if ($validator->fails()) {

            $errors = collect($validator->errors())->flatten(1)[0];

            if (is_numeric($errors)) {

                $errors_arr = [

                    406 => 'Failed,phone not found',

                ];
                $code = collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }
        $data = $request->validate($rules);
        $user = User::where($data);
        if ($user->count()) {
            if (!$token = JWTAuth::fromUser($user->firstOrFail())) {
                return helperJson(null, 'there is no user', 406);
            }
            $user = $user->firstOrFail();
            $user->token = $token;
            if ($user->user_type == 'client')
                return helperJson(new UserResources($user), 'good login');
            elseif ($user->user_type == 'freelancer')
                return helperJson(new UserResources($user), 'good login');
        } else {
            return helperJson(null, 'there is no user', 406);
        }


    }//end fun

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $rules = [

            'phone_code'  => 'required',
            'phone'       => 'required',
            'city_id'     => 'required|exists:cities,id',
            'first_name'  => 'required|min:2|max:191',
            'last_name'   => 'required|min:2|max:191',
            'email'       => 'required|unique:users,email',
            'birthdate'   => 'required|before:today',
            'image'       => 'nullable',
            'user_type'   => 'required|in:client,freelancer,adviser',
            'years_ex'    => 'nullable|numeric',
            'category_id' => 'nullable|exists:categories,id'
        ];
        $validator = Validator::make($request->all(), $rules, [
//            'phone.unique' => 409,
            'email.unique' => 410,
            'birthdate.before' => 411,
        ]);

        $first_name = $request->first_name;
        $last_name = $request->first_name;
        if (!preg_match('/[اأإء-ي]/ui', $first_name) || !preg_match('/[اأإء-ي]/ui', $last_name)) {
            return helperJson(null,"يرجي ادخال اسم باللغة العربية" , 505);
        } else {


            if ($validator->fails()) {
                $errors = collect($validator->errors())->flatten(1)[0];
                if (is_numeric($errors)) {
                    $errors_arr = [
//                        409 => 'Failed,phone number already exists',
                        410 => 'Failed,email already exists',
                        411 => 'birthdate should be correct',
                    ];
                    $code = collect($validator->errors())->flatten(1)[0];
                    return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
                }
                return helperJson(null, $validator->errors(), 422);
            }
            $data = $request->validate($rules);

            if($request->user_type == 'freelancer' && $request->category_id == null){
                return helperJson(null,'يرجي اختيار كاتيجوري في حالة التسجيل كمقدم خدمة',420);
            }

            if(User::where('user_type','=',$request->user_type)->where('phone','=',$request->phone)->exists()){

                return response()->json([

                    'code' => 422,
                    'message' => 'phone already exists by freelancer and client'
                ]);
            }


            if ($request->hasFile('image')) {
                $data['image'] = $this->uploadFiles('users', $request->file('image'));
            } else {
//                $data['image'] = $this->storeDefaultImage('users', $request->first_name . ' ' . $request->last_name);
                $data['image'] = NULL;
            }
            $data['user_type'] = $request->user_type;

            $user = User::create($data);


            if ($user) {
                if (!$token = JWTAuth::fromUser($user)) {
                    return helperJson(null, 'there is no user', 430);
                }
            }
            $user->token = $token;

            return helperJson(new UserResources($user), 'good');

//            if ($user->user_type == 'client')
//                return helperJson(new UserResources($user), 'good');
//            elseif ($user->user_type == 'freelancer')
//                return helperJson(new UserResources($user), 'good');
//            else
//                return helperJson(new UserResources($user), 'good');
        }


    }//end fun

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $rules = [
            'token' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        } else {

            PhoneTokens::where('token', $request->token)->delete();
            \api()->logout();
            return helperJson(null, 'log out successfully', 200);
        }

    }//end fun

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfile(Request $request)
    {
        $token = '';
        if (\api()->check()) {
            if (!$token = JWTAuth::fromUser(\api()->user())) {
                return helperJson(null, 'there is no user', 430);
            }
        }
        api()->user()->token = $token;

            return helperJson(new UserResources(api()->user()), 'good');
        
    }//end fun

    /**
     * @param $token
     * @param $user
     * @return array
     */
    protected function respondWithToken($token, $user)
    {
        return [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
//            'expires_in' => auth()->factory()->getTTL()
        ];
    }//end fun
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    //======================================================
    //======================================================
    public function updateProfile(Request $request)
    {


        $user = \api()->user();

        $rules = [
//            'phone_number'=>'required|unique:customers,phone_number',
            'phone_code' => 'nullable',
            'phone' => "nullable|unique:users,phone,{$user->id}",
            'first_name' => 'required|min:2|max:191',
            'last_name' => 'required|min:2|max:191',
            'email' => "nullable|unique:users,email,{$user->id}",
            'image' => 'nullable',
            'city_id' => 'required|exists:cities,id',
            'birthdate' => 'required|before:today',
            'years_ex' => 'nullable|numeric',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'phone.unique' => 409,
            'email.unique' => 410,
            'birthdate.before' => 411,
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [
                    409 => 'Failed,phone number already exists',
                    410 => 'Failed,email already exists',
                    411 => 'birthdate should be correct',
                ];
                $code = collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        } else {
            $data = $request->all();
//            $user = Customers::where('id',$request->id)->first();

            if ($request->hasFile('image')) {
                $data['image'] = $this->uploadFiles('users', $request->file('image'), api()->user()->image);
            }
            $user->update($data);
            if (!$token = JWTAuth::fromUser($user)) {
                return helperJson(null, 'there is no user', 430);
            }
            $user->token = $token;

            return helperJson(new UserResources($user), 'profile updated successfully');
        }

    }//end fun
    //==========================================================
    //==========================================================
    public function insertToken(Request $request)
    {
        $rules = [
            'token' => 'required',
            'type' => 'required|in:android,ios',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }

        $data = $request->except('country');
        $data['user_id'] = api()->user()->id;

        PhoneTokens::updateOrCreate($data);
        return helperJson(null, 'successfully');

    }//end fun


    public function userServiceRequest(){


        try {

            $services = ServiceRequest::query()->where('user_id','=',auth('api')->id())->latest()->get();

            if($services->count() > 0)

                return returnDataSuccess( "تم الحصول علي طلبات المستخدم بنجاح",200,"orders",ServiceRequestResources::collection($services));

            else
                return returnMessageError("لا يوجد اي طلبات حاليا تابعه لهذا العميل",500);



        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),500);

        }


    }


}//end class
