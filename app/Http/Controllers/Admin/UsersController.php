<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Cities;
use App\Models\User;
use App\Traits\PhotoTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFreelancer;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use function Symfony\Component\String\s;

class UsersController extends Controller
{
    use PhotoTrait;

    public function client(request $request)
    {
        if ($request->ajax()) {
            $clients = User::where('user_type', 'client')->select('*');

            return Datatables::of($clients)
                ->addColumn('action', function ($clients) {
                    return '
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $clients->id . '" data-title="' . $clients->first_name . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('image', function ($clients) {
                    return '
                    <img alt="image" onclick="window.open(this.src)" class="avatar avatar-md rounded-circle" src="' . get_user_file($clients->image) . '">
                    ';
                })
                ->editColumn('status', function ($data) {
                    if($data->status == 0)
                        $span = '<span style="cursor: pointer" data-id="'.$data->id.'" class="badge badge-danger statusSpan">محظور</span';
                    else
                        $span = '<span style="cursor: pointer" data-id="'.$data->id.'"  class="badge badge-success statusSpan">مفعل</span';

                    return $span;
                })
                ->editColumn('created_at', function ($user) {
                return $user->created_at ? with(new Carbon($user->created_at))->format('m/d/Y') : '';
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%m/%d/%Y') like ?", ["%$keyword%"]);
                })
                ->escapeColumns([])
                ->make(true);
        } else {

            return view('Admin.users.client');
        }

    } //end of index

    public function userActivation(Request $request)
    {
        $user = User::find($request->id);
        ($user->status == '0') ? $user->status = '1' : $user->status = '0';
        $user->save();
        return response()->json(
            [
                'success' => true,
                'message' => 'تم تغيير حالة المستخدم بنجاح'
            ]);
    }

    public function client_delete(Request $request)
    {
        $client = User::where('id', $request->id)->first();

        $client->delete();
        return response(['message'=>'تم الحذف بنجاح','status'=>200],200);

    } //end of delete

    public function freelancer(request $request)
    {
        if ($request->ajax()) {
            $freelancers = User::where('user_type', 'freelancer')->select('*');
            return Datatables::of($freelancers)
                ->addColumn('action', function ($freelancers) {
                    return '
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $freelancers->id . '" data-title="' . $freelancers->first_name . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('image', function ($freelancers) {
                    return '
                    <img alt="image" onclick="window.open(this.src)" class="avatar avatar-md rounded-circle" src="' . get_user_file($freelancers->image) . '">
                    ';
                })
                ->editColumn('category_id', function ($freelancers){
                  return $freelancers->category->title_ar;
                })
                ->editColumn('status', function ($data) {
                    if($data->status == 0)
                        $span = '<span style="cursor: pointer" data-id="'.$data->id.'" class="badge badge-danger statusSpan">محظور</span';
                    else
                        $span = '<span style="cursor: pointer" data-id="'.$data->id.'"  class="badge badge-success statusSpan">مفعل</span';

                    return $span;
                })
                ->editColumn('created_at', function ($user) {
                    return $user->created_at ? with(new Carbon($user->created_at))->format('m/d/Y') : '';
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%m/%d/%Y') like ?", ["%$keyword%"]);
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('Admin.users.freelancer');
        }
    } //end of index

    public function freelancer_create()
    {
        $categories  = Category::get();
        $cities = Cities::get();
        return view('Admin.users.parts.create',compact('categories', 'cities'));
    }// end of create

    public function freelancer_store(StoreFreelancer $request)
    {
        $inputs = $request->all();
        if ($request->has('image')) {
            $inputs['image'] = $this->saveImage($request->image, 'assets/uploads/users', 'photo');
        }
        if (User::create($inputs))
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
    } // end store

    public function freelancer_delete(Request $request)
    {
        $freelancer = User::where('id', $request->id)->first();

        $freelancer->delete();
        return response(['message'=>'تم الحذف بنجاح','status'=>200],200);

    } //end of delete

    public function adviser(request $request)
    {
        if ($request->ajax()) {
            $advisers = User::where('user_type', 'adviser')->select('*');
            return Datatables::of($advisers)
                ->addColumn('action', function ($advisers) {
                    return '
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $advisers->id . '" data-title="' . $advisers->first_name . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('image', function ($advisers) {
                    return '
                    <img alt="image" onclick="window.open(this.src)" class="avatar avatar-md rounded-circle" src="' . get_user_file($advisers->image) . '">
                    ';
                })
                ->editColumn('status', function ($data) {
                    if($data->status == 0)
                        $span = '<span style="cursor: pointer" data-id="'.$data->id.'" class="badge badge-danger statusSpan">محظور</span';
                    else
                        $span = '<span style="cursor: pointer" data-id="'.$data->id.'"  class="badge badge-success statusSpan">مفعل</span';

                    return $span;
                })
                ->editColumn('created_at', function ($user) {
                    return $user->created_at ? with(new Carbon($user->created_at))->format('m/d/Y') : '';
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%m/%d/%Y') like ?", ["%$keyword%"]);
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('Admin.users.adviser');
        }
    } //end of index
    public function adviser_delete(Request $request)
    {
        $adviser = User::where('id', $request->id)->first();

        $adviser->delete();
        return response(['message'=>'تم الحذف بنجاح','status'=>200],200);

    } //end of delete


} //end of class
