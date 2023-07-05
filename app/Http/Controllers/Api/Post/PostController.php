<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResources;
use App\Models\Posts;
use App\Models\PostsConsultant;
use App\Traits\DefaultImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function collect;
use function helperJson;
use function response;

class PostController extends Controller
{
    use DefaultImage;
    public function storePost(Request $request)
    {
        $rules = [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required',
            'text' => 'required',
            'image'=>'nullable|image',
            'consultants_ids'=>'required|array',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'category_id.exists' => 404,
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [
                    404 => 'Failed,category not found',
                ];
                $code = collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }
        $data = $request->only('title','text','category_id');

        if ($request->hasFile('image') && $request->image != null){
            $data['image'] = $this->uploadFiles('posts',$request->image);
        }

        $data['user_id'] = api()->user()->id;
       $store = Posts::create($data);

       foreach($request->consultants_ids as $consultants_id)
       {
           $smallInput['consultant_type_id'] = $consultants_id;
           $smallInput['post_id'] = $store->id;
           try{
               PostsConsultant::create($smallInput);
           }catch (\Exception $e){

           }
       }

       return helperJson(new PostResources($store));

    }//end fun
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function editPost(Request $request)
    {
        $rules = [
            'post_id' => 'required|exists:posts,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required',
            'text' => 'required',
            'image'=>'nullable|image',
            'consultants_ids'=>'required|array',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'category_id.exists' => 404,
            'post_id.exists' => 406,
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [
                    404 => 'Failed,category not found',
                    406 => 'Failed,Post not found',
                ];
                $code = collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }
        $data = $request->only('title','text','category_id');

        if ($request->hasFile('image')){
            $data['image'] = $this->uploadFiles('posts',$request->image);
        }

        $data['user_id'] = api()->user()->id;
       $store = Posts::find($request->post_id)->update($data);

        PostsConsultant::where('post_id',$request->post_id)->delete();

       foreach($request->consultants_ids as $consultants_id)
       {
           $smallInput['consultant_type_id'] = $consultants_id;
           $smallInput['post_id'] = $request->post_id;
           try{
               PostsConsultant::create($smallInput);
           }catch (\Exception $e){

           }
       }

       return helperJson(new PostResources(Posts::find($request->post_id)));

    }//end fun
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function deletePost(Request $request)
    {
        $rules = [
            'post_id' => 'required|exists:posts,id',

        ];
        $validator = Validator::make($request->all(), $rules, [
            'post_id.exists' => 404,
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [
                    404 => 'Failed,Post not found',
                ];
                $code = collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }
        Posts::destroy($request->post_id);

        return helperJson(null,'done');
    }//end fun
}//end class
