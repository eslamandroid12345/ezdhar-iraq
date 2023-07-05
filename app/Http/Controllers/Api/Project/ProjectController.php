<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\DefaultImage;
use App\Models\Project;
use App\Http\Resources\ProjectResource;
use App\Models\ProjectReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    use DefaultImage;
    public function storeProject(request $request){
        $rules = [
            'category_id'           => 'required|exists:categories,id',
            'title_ar'                 => 'required',
            'title_en'                 => 'required',
            'text_ar'                  => 'required',
            'text_en'                  => 'required',
            'ownership_rate'        => 'required|numeric|between:1,99',
            'is_investment'         => 'nullable|in:0,1',
            'image'                 =>'nullable|image',
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
        $data = $request->only('title_ar','text_ar','title_en','text_en','category_id','ownership_rate','cost','is_investment');

        if ($request->hasFile('image') && $request->image != null){
            $data['image'] = $this->uploadFiles('projects',$request->image);
        }

        $data['user_id'] = api()->user()->id;
        $project = Project::create($data);

        $category = Category::find($request->category_id);
        foreach($category->sub_categories as $sub)
        {
            $review['sub_category_id'] = $sub->id;
            $review['project_id'] = $project->id;
            try{
                ProjectReview::create($review);
            }catch (\Exception $e){
                return helperJson($e->getMessage());
            }
        }
        return helperJson(new ProjectResource($project));
    }

    public function editProject(request $request){
        $rules = [
            'project_id'     => 'required|exists:projects,id',
            'category_id'    => 'required|exists:categories,id',
            'title_ar'                 => 'required',
            'text_ar'                  => 'required',
            'title_en'                 => 'required',
            'text_en'                  => 'required',
            'image'          => 'nullable|image',
            'ownership_rate' => 'nullable',
            'cost'           => 'nullable',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'category_id.exists' => 404,
            'project_id.exists'  => 406,
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {
                $errors_arr = [
                    404 => 'Failed,category not found',
                    406 => 'Failed,Project not found',
                ];
                $code = collect($validator->errors())->flatten(1)[0];
                return helperJson(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return response()->json(['data' => null, 'message' => $validator->errors(), 'code' => 422], 200);
        }


        $project = Project::find($request->project_id);

        // لو مستشار عمل اعتماد اليوزر صاحب المشروع ميقدرش يعدله
        foreach ($project->reviews as $review){
            if($review->user_id != null){
                return helperJson(null,'تم تقديم اعتماد لهذا المشروع من احد المستشارين فلا يمكن تعديله',405);
            }
        }
        ///////////////////////////////////////

        $data = $request->only('title_ar','text_ar','title_en','text_en','category_id','ownership_rate','cost','is_investment');

        if ($request->hasFile('image')){
            $data['image'] = $this->uploadFiles('projects',$request->image);
        }

        $store = Project::find($request->project_id)->update($data);

        ProjectReview::where('project_id',$request->project_id)->delete();

        $category = Category::find($request->category_id);
        foreach($category->sub_categories as $sub)
        {
            $review['sub_category_id'] = $sub->id;
            $review['project_id'] = $project->id;
            try{
                ProjectReview::create($review);
            }catch (\Exception $e){
                return helperJson($e->getMessage());
            }
        }
        return helperJson(new ProjectResource($project));
    }


    //start get all projects
    public function projects(){


        try {

            $projects = Project::where('user_id','=',auth('api')->id())->get();


            if($projects->count() > 0){

                return returnDataSuccess("تم الحصول علي جميع المشاريح  بنجاح",200,'projects',ProjectResource::collection($projects));

            }else{

                return returnMessageError("لا يوجد مشاريع الي الان مسجله","500");

            }

        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),"500");


        }
    }
}
