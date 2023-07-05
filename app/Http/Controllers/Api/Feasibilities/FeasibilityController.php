<?php

namespace App\Http\Controllers\Api\Feasibilities;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Feasibility;
use App\Models\FeasibilityType;
use App\Models\FeasibilityCategory;
use App\Models\FeasibilitySubCategory;
use App\Http\Resources\FeasibilityTypeResources;
use App\Http\Resources\FeasibilityResources;

class FeasibilityController extends Controller{


    public function storeFeasibilityType(Request $request){

        try {

            $rules = [

                'type' => 'required',
                'img' => 'required|image',
            ];


            $messages = [

                'type.required' => 'نوع دراسه الجدول مطلوبه',
                'img.required' => 'صوره نوع دراسه الجدول مطلوبه',
                'img.image' => 'ملف دراسه الجدول يجب ان يكون صوره',


            ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if ($validator->fails()){

                return returnMessageError($validator->errors(),500);
            }


            if ($image = $request->file('img')) {

                $destinationPath = 'feasibilities/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $request['img'] = "$profileImage";
            }

            $feasibilityType =  new FeasibilityType();
            $feasibilityType->type = $request->type;
            $feasibilityType->img = $profileImage;
            $feasibilityType->save();


            if($feasibilityType){

                return returnDataSuccess("تم تسجيل البيانات بنجاح",201,"feasibilityType",new FeasibilityTypeResources($feasibilityType));
            }


        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),"500");


        }

    }


    public function allFeasibilityType(){

        try {

            $allFeasibilityType = FeasibilityType::get();


            if($allFeasibilityType->count() > 0){

                return returnDataSuccess("تم الحصول علي انواع دراسه الجدول بنجاح",200,"FeasibilityType",FeasibilityTypeResources::collection($allFeasibilityType));

            }else{

                return returnMessageError("لا يوجد بيانات مسجله مسبقا","500");

            }



        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),"500");


        }

    }


    public function storeFeasibility(Request $request){

//        return $request;
        try {

            $rules = [

                'feasibility_type_id' => 'required|exists:feasibility_types,id',
                'img' => 'required|image',
                'project_name' => 'required',
                'ownership_rate' => 'required',
                'note' => 'required',
                'details' => 'required',
                'show' => 'required',
            ];


            $messages = [

                'feasibility_type_id.required' => 'نوع دراسه الجدول مطلوب',
                'project_name.required' => 'اسم المشروع مطلوب',
                'img.required' => 'صوره دراسه الجدول مطلوبه',
                'img.image' => 'ملف دراسه الجدول يجب ان يكون صوره',
                'ownership_rate.required' => 'تقييم صاحب العمل مطلوب',
                'note.required' => 'نبذه الدراسه مطلوبه',
                'details.required' => 'التفاصيل مطلوبه',
                'show.required' => 'هل تريد عرض مشروعك',

            ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if ($validator->fails()){

                return returnMessageError($validator->errors(),500);
            }


            if ($image = $request->file('img')) {

                $destinationPath = 'feasibilities/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $request['img'] = "$profileImage";
            }


            $feasibility =  new Feasibility();
            $feasibility->feasibility_type_id = $request->feasibility_type_id;
            $feasibility->user_id = auth('api')->id();
            $feasibility->img = $profileImage;
            $feasibility->project_name = $request->project_name;
            $feasibility->ownership_rate = $request->ownership_rate;
            $feasibility->note = $request->note;
            $feasibility->details = $request->details;
            $feasibility->show = $request->show;
            $feasibility->total = $request->total;
            $feasibility->save();


            if(isset($request->category)){
                foreach($request->category as $category) {

                    $row = FeasibilityCategory::create([

                        "feasibility_id" => $feasibility->id,
                        "price" => $category['price'],
                        "details"  => $category['details'],
                    ]);


                    if(isset($category['sub_category'])){

                        $sub = $row->FeasibilitySubCategory()->createMany($category['sub_category']);
                        if(isset($sub)) {
                            foreach ($sub as $key => $item) {
                                $item->FeasibilitySubSubCategory()->createMany($category['sub_category'][$key]['subsub']);
                            }
                        }
                    }


                }
            }



//           $feasibility->FeasibilityCategory()->createMany($request->category);

            if($feasibility){

                return returnDataSuccess("تم تسجيل البيانات بنجاح",201,"feasibility",new FeasibilityResources($feasibility));
            }


        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),"500");


        }

    }


    public function allFeasibility($id){

        try {

            $allFeasibility = Feasibility::where('feasibility_type_id','=',$id)->where('user_id','=',auth('api')->id())->get();


            if($allFeasibility->count() > 0){

                return returnDataSuccess("تم الحصول علي جميع دراسه الجدول بنجاح",200,"allFeasibility",FeasibilityResources::collection($allFeasibility));

            }else{

                return returnMessageError("لا يوجد سجلات","500");

            }



        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),"500");


        }

    }


}//end class
