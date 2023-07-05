<?php

namespace App\Http\Controllers\Api\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Report;
use App\Http\Resources\ReportResources;
use App\Http\Controllers\Controller;


class ReportFromUserController extends Controller{


    public function index(){


        try {

            $reports = Report::query()->latest()->get();

            return returnDataSuccess("تم الحصول علي جميع التقارير من قبل المستخدمين", 200, "reports",ReportResources::collection($reports));

        } catch (\Exception $exception) {

            return returnMessageError($exception->getMessage(), 500);


        }
    }


    public function store(Request $request){

        try {


            $rules = [

                'reason'=> 'required',
                'photo'=> 'nullable|image',
                'details'=> 'required',
                'provider_id'=> 'required|exists:users,id',

            ];


            $messages = [

                'reason.required' => 'سبب المشكله مطلوب',
                'photo.image' => 'الصوره المرفقه يجب ان تكون صوره',
                'details.required' => 'اوصف تعاملك مع مقدم الخدمه',
                'provider_id.required' => 'يرجي ادخال رقم مقدم الخدمه',
                'provider_id.exists' => 'رقم مقدم الخدمه غير موجود بسجل البيانات',


            ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if ($validator->fails()){

                return returnMessageError($validator->errors(),500);
            }

            if ($image = $request->file('photo')) {

                $destinationPath = 'reports/';
                $profileImage = time() . rand(1,10000) . uniqid() . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $request['photo'] = "$profileImage";
            }

            $report = Report::create([

                'reason'=> $request->reason,
                'details'=> $request->details,
                'photo'=> $profileImage ?? NULL,
                'provider_id'=> $request->provider_id,
                'user_id'=> auth('api')->id(),

            ]);

            if(isset($report)){


                return returnDataSuccess("تم رفع التقرير للادمن",200,"report",new ReportResources($report));

            }

        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),500);

        }

    }


    public function delete($id){

        try {

            $report = Report::find($id);

            if(!$report)
                return returnMessageError("هذا التقرير غير موجود بسجل البيانات",500);

            else
                if(file_exists(public_path('/reports/' . $report->photo)) && $report->photo !== NULL){

                    unlink(public_path('/reports/' . $report->photo));
                    $report->delete();
                    return returnMessageError("تم حذف التقرير بنجاح",200);


                }elseif($report->photo == NULL){

                    $report->delete();
                    return returnMessageError("تم حذف التقرير بنجاح",200);


                } else{

                    return returnMessageError("فشل حذف الصوره القديمه من سجل الصور",500);
            }



        }catch (\Exception $exception){

            return returnMessageError($exception->getMessage(),500);

        }


    }

    

}
