<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjects;
use App\Models\Category;
use App\Models\Posts;
use App\Traits\PhotoTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PostController extends Controller
{
    use PhotoTrait;

    public function index(request $request)
    {
        if($request->ajax()) {
            $posts = Posts::select('*');
            return Datatables::of($posts)
                ->addColumn('action', function ($posts) {
                    return '
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $posts->id . '" data-title="' . $posts->title_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('image', function ($posts) {
                    if ($posts->image == null) {
                        return ' --No Data-- ';
                    }
                    else {
                        return '
                    <img alt="image" onclick="window.open(this.src)" class="avatar avatar-md rounded-circle" src="'.asset('jobs/' . $posts->image).'">
                    ';
                    }
                })
                ->editColumn('status', function ($data) {
                    if($data->status == 0)
                        $span = '<span style="cursor: pointer" data-id="'.$data->id.'" class="badge badge-danger statusSpan">معلق</span';
                    else
                        $span = '<span style="cursor: pointer" data-id="'.$data->id.'"  class="badge badge-success statusSpan">منشور</span';

                    return $span;
                })
                ->addColumn('post', function ($posts) {
                    return '
                             <button type="button" data-id="' . $posts->id . '" class="btn btn-pill btn-primary-light showBtn">
                             <i class="fas fa-window-maximize"></i> عرض</button>
                       ';
                })


//                ->editColumn('created_at', function ($user) {
//                    return $user->created_at ? with(new Carbon($user->created_at))->format('m/d/Y') : '';
//                })
//                ->filterColumn('created_at', function ($query, $keyword) {
//                    $query->whereRaw("DATE_FORMAT(created_at,'%m/%d/%Y') like ?", ["%$keyword%"]);
//                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin.posts.index');
        }
    } //end of index


    public function delete(Request $request)
    {
        $posts = Posts::where('id', $request->id)->first();

            $posts->delete();
            return response(['message'=>'تم الحذف بنجاح','status'=>200],200);
    } //end of delete


    public function PostActivation(Request $request)
    {
        $posts = Posts::find($request->id);
        ($posts->status == '0') ? $posts->status = '1' : $posts->status = '0';
        $posts->save();
        return response()->json(
            [
                'success' => true,
                'message' => 'تم تغيير حالة المستخدم بنجاح'
            ]);
    }

    public function details(Request $request)
    {
        $post = Posts::where('id', $request->id)->first();

        return view('Admin.posts.show', compact('post'));
    }
}
