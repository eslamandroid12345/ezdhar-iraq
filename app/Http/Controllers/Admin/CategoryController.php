<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategory;
use App\Models\Category;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    use PhotoTrait;

    public function index(request $request)
    {
        if ($request->ajax()) {
            $categories = Category::latest()->get();
            return Datatables::of($categories)
                ->addColumn('action', function ($categories) {
                    return '
                            <button type="button" data-id="' . $categories->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $categories->id . '" data-title="' . $categories->title_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('image', function ($categories) {
                    return '
                    <img alt="image" onclick="window.open(this.src)" class="avatar avatar-md rounded-circle" src="' . get_user_file($categories->image) . '">
                    ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('Admin.category.index');
        }
    } //end index


    public function delete(Request $request)
    {
        $category = Category::where('id', $request->id)->first();
            if (file_exists($category->image)) {
                unlink($category->image);
            }
            $category->delete();
            return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    } // end delete

    public function create()
    {
        return view('Admin.category.parts.create');
    } //end create

    public function store(StoreCategory $request)
    {
        $inputs = $request->all();
        if ($request->has('image')) {
            $inputs['image'] = $this->saveImage($request->image, 'assets/uploads/categories', 'photo');
        }
        if (Category::create($inputs))
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
    } // end store

    public function edit(Category $category)
    {
        return view('Admin.category.parts.edit', compact('category'));
    } // end edit

    public function update(StoreCategory $request, $id)
    {
        $inputs = $request->except('id');

        $category = Category::findOrFail($id);

        if ($request->has('image')) {
            if (file_exists($category->image)) {
                unlink($category->image);
            }
            $inputs['image'] = $this->saveImage($request->image, 'assets/uploads/categories','photo');
        }
        if ($category->update($inputs))
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
    } // end of update

}//end class
