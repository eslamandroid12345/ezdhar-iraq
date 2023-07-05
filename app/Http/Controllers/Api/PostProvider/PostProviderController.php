<?php

namespace App\Http\Controllers\Api\PostProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PostProvider;
use App\Models\PostProviderAction;
use App\Http\Resources\PostProviderResources;
use App\Http\Resources\PostProviderMakeLoveResource;
use App\Http\Controllers\Controller;


class PostProviderController extends Controller{


    public function all(Request $request){


        try {

            $postProviders = PostProvider::query()->where('status','=',true)->latest()->get();

            return returnDataSuccess("posts all providers get successfully", 200, "posts",PostProviderResources::collection($postProviders));

        } catch (\Exception $exception) {

            return returnMessageError($exception->getMessage(), 500);


        }
    }


    public function store(Request $request){

        try {


            $rules = [

                'description'=> 'required',
                'image'=> 'required|image',

            ];


            $messages = [

            'description.required' => 'description title is required',
            'image.required' => 'image field is required',
            'image.image' => 'image must be an image',


            ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if ($validator->fails()){

                return returnMessageError($validator->errors(),422);
            }


            if ($image = $request->file('image')) {

                $destinationPath = 'jobs/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $request['image'] = "$profileImage";
            }

            $postProvider = PostProvider::create([

                'description'=> $request->description,
                'image' => $profileImage,
                'provider_id'=> auth('api')->id(),

            ]);

            if(isset($postProvider)){

                return returnDataSuccess("post by provider created successfully",200,"post",new PostProviderResources($postProvider));

            }

        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),500);

        }


    }


    public function update(Request $request,$id){

        try {


            $rules = [

                'description'=> 'required',
                'image'=> 'nullable|image',

            ];


            $messages = [

                'description.required' => 'description title is required',
                'image.image' => 'image must be an image',

            ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if ($validator->fails()){

                return returnMessageError($validator->errors(),422);
            }


            if ($image = $request->file('image')) {

                $destinationPath = 'jobs/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $request['image'] = "$profileImage";
            }

            $postProvider = PostProvider::find($id);

            if(!$postProvider){

                return returnMessageError("post provider not found",404);
            }

            $postProvider->update([

                'description'=> $request->description,
                'image' => $request->file('image') ? $profileImage : $postProvider->image,
                'provider_id'=> auth('api')->id(),

            ]);

            if(isset($postProvider)){

                return returnDataSuccess("post updated successfully",200,"post",new PostProviderResources($postProvider));

            }

        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),500);

        }


    }

    public function actions(Request $request){

//        return "hello";

        try {
            $rules = [

                'post_provider_id'=> 'required|exists:post_providers,id',
                'action'=> 'required|in:love,unlove',

            ];


            $messages = [


                'post_provider_id.required' => 'رقم البوست مطلوب',
                'post_provider_id.exists' => 'رقم البوست غير موجود بقاعده البيانات',
                'action.required' => 'يرجي عمل love',
                'action.in' => 'يرجي ادخال love او unlove'

            ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if ($validator->fails()){

                return returnMessageError($validator->errors(),422);
            }


            $postAction = PostProviderAction::where('user_id','=',auth('api')->id())->where('post_provider_id','=',$request->post_provider_id)->first();

            if(!$postAction){

               $action =  PostProviderAction::create([

                    'user_id' => auth('api')->id(),
                    'post_provider_id' => $request->post_provider_id,
                    'action' => $request->action,
                ]);

                return returnDataSuccess("user make love successfully",200,"post_provider_actions",$action);

            }else{

                $postAction->update([

                    'post_provider_id' => $request->post_provider_id,
                    'action' => $request->action,
                ]);

                return returnDataSuccess("user update action successfully",200,"post_provider_actions",$postAction);

            }


        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),500);

        }


    }

    public function allPostsFromProvider(){


        try {

            $postProviders = PostProvider::query()->where('provider_id','=',auth('api')->id())->where('status','=',true)->latest()->get();

            if($postProviders->count() > 0){

                return returnDataSuccess("all posts of provider get successfully", 200, "posts",PostProviderResources::collection($postProviders));

            }else{

                return returnMessageError("There are no posts yet",404);
            }

        } catch (\Exception $exception) {

            return returnMessageError($exception->getMessage(), 500);


        }

    }


    public function postsLoveByUser()
    {
        $IdForPosts = PostProviderAction::where('user_id', auth('api')->id())->where('action','love')->latest()->pluck('post_provider_id')->toArray();
        $data = PostProvider::whereIn('id',$IdForPosts)->get();

        return returnDataSuccess("all posts love by user get successfully", 200, "posts",PostProviderMakeLoveResource::collection($data));


    }//end fun




}
