<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeasibilityStudy;
use App\Models\FeasibilityType;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FeasibilityTypeController extends Controller
{
    use PhotoTrait;

    public function index(request $request)
    {
        if($request->ajax()) {
            $feasibility_study = FeasibilityType::select('*');
            return Datatables::of($feasibility_study)
                ->addColumn('action', function ($feasibility_study) {
                    return '
                            <button type="button" data-id="' . $feasibility_study->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $feasibility_study->id . '" data-title="' . $feasibility_study->name . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->addColumn('img', function ($data){
                    return
                        '<img alt="image" onclick="window.open(this.src)" class="avatar avatar-md rounded-circle" src="'.asset($data->img).'">';
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin.feasibility_type.index');
        }
    } //end of index


    public function delete(Request $request)
    {
        $feasibility_study = FeasibilityType::where('id', $request->id)->first();

        $feasibility_study->delete();
        return response(['message'=>'تم الحذف بنجاح','status'=>200],200);
    } //end of delete


    public function create(){
        return view('Admin.feasibility_type.parts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'img' => 'required|mimes:jpeg,jpg,png,gif',
        ],[
            'type.required'              => 'يرجي ادخال النوع',
            'img.required'              => 'يرجي ادخال الصورة',
        ]);

        $inputs = $request->all();
        if($request->has('img')){
            $inputs['img'] = $this->saveImage($request->img,'assets/uploads/feasibility_type');
        }
        if(FeasibilityType::create($inputs))
            return response()->json(['status'=>200]);
        else
            return response()->json(['status'=>405]);
    }

    public function edit(FeasibilityType $feasibility_type){
        return view('Admin.feasibility_type.parts.edit',compact('feasibility_type'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'type' => 'required',
            'img' => 'required|mimes:jpeg,jpg,png,gif',
        ],[
            'type.required'              => 'يرجي ادخال النوع',
            'img.required'              => 'يرجي ادخال الصورة',
        ]);

        $inputs = $request->except('id');

        $feasibility_type = FeasibilityType::findOrFail($id);

        if ($request->has('img')) {
            if (file_exists($feasibility_type->img)) {
                unlink($feasibility_type->img);
            }
            $inputs['img'] = $this->saveImage($request->img, 'assets/uploads/feasibility_type');
        }
        if ($feasibility_type->update($inputs))
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
    }
}
