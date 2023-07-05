<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeasibilityStudy;
use App\Models\Feasibility;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class FeasibilityStudyController extends Controller
{
    use PhotoTrait;

    public function index(request $request)
    {
        if($request->ajax()) {
            $feasibility_study = Feasibility::select('*');
            return Datatables::of($feasibility_study)
                ->addColumn('action', function ($feasibility_study) {
                    return '

                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $feasibility_study->id . '" data-title="' . $feasibility_study->name . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('img', function ($feasibility_study) {
                    return '
                    <img alt="image" onclick="window.open(this.src)" class="avatar avatar-md rounded-circle" src="'.asset($feasibility_study->img).'">
                    ';
                })
                ->editColumn('feasibility_type_id', function ($feasibility_study){
                    return $feasibility_study->feasibilityType->type;
                })
                ->editColumn('user_id',function ($feasibility_study){
                  return $feasibility_study->user->first_name;
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin.feasibility_study.index');
        }
    } //end of index


    public function delete(Request $request)
    {
        $feasibility_study = Feasibility::where('id', $request->id)->first();

            $feasibility_study->delete();
            return response(['message'=>'تم الحذف بنجاح','status'=>200],200);
    } //end of delete


    public function create(){
        return view('Admin.feasibility_study.parts.create');
    }

    public function store(StoreFeasibilityStudy $request)
    {
        $inputs = $request->all();
        if($request->has('image')){
            $inputs['image'] = $this->saveImage($request->image,'assets/uploads/feasibility_study');
        }
        if(Feasibility::create($inputs))
            return response()->json(['status'=>200]);
        else
            return response()->json(['status'=>405]);
    }

    public function edit(Feasibility $feasibility_study){
        return view('Admin.feasibility_study.parts.edit',compact('feasibility_study'));
    }

    public function update(StoreFeasibilityStudy $request,$id)
    {
        $inputs = $request->except('id');

        $feasibility_study = Feasibility::findOrFail($id);

        if ($request->has('image')) {
            if (file_exists($feasibility_study->image)) {
                unlink($feasibility_study->image);
            }
            $inputs['image'] = $this->saveImage($request->image, 'assets/uploads/feasibility_study');
        }
        if ($feasibility_study->update($inputs))
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
    }
}

//  <button type="button" data-id="' . $feasibility_study->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
