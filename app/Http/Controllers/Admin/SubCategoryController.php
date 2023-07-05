<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubCategory;
use App\Models\Category;
use App\Models\SubCategory;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubCategoryController extends Controller
{
    use PhotoTrait;

    public function index(request $request)
    {
        if ($request->ajax()) {

            $subcategories = SubCategory::select('*');
            return Datatables::of($subcategories)
                ->addColumn('action', function ($subcategories) {
                    return '
                            <button type="button" data-id="' . $subcategories->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $subcategories->id . '" data-title="' . $subcategories->title_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('image', function ($subcategories) {
                    return '
                    <img alt="image" onclick="window.open(this.src)" class="avatar avatar-md rounded-circle" src="' . get_user_file($subcategories->image) . '">
                    ';
                })
                ->editColumn('category_id', function ($subcategories) {
                    return $subcategories->category->title_ar;
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('Admin.subcategory.index');
        }//end if
    } //end index


    public function delete(Request $request)
    {
        $subcategory = SubCategory::where('id', $request->id)->first();
        if (file_exists($subcategory->image)) {
            unlink($subcategory->image);
        }
        $subcategory->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    } //end delete

    public function create()
    {
        $categories = Category::all();
        return view('Admin.subcategory.parts.create')->with([

            'categories' => $categories
        ]);
    }//end create

    public function store(StoreSubCategory $request)
    {
        $inputs = $request->all();
        if ($request->has('image')) {
            $inputs['image'] = $this->saveImage($request->image, 'assets/uploads/subcategories','photo');
        }
        if (SubCategory::create($inputs))
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
    } //end store

    public function edit(SubCategory $subcategory)
    {
        $categories = Category::all();
        return view('Admin.subcategory.parts.edit', compact('subcategory','categories'));
    } //end edit

    public function update(StoreSubCategory $request, $id)
    {
        $inputs = $request->except('id');

        $subcategory = SubCategory::findOrFail($id);

        if ($request->has('image')) {
            if (file_exists($subcategory->image)) {
                unlink($subcategory->image);
            }
            $inputs['image'] = $this->saveImage($request->image, 'assets/uploads/subcategories','photo');
        }
        if ($subcategory->update($inputs))
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
    } //end update
} //end class
