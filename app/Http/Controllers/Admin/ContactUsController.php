<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ContactUsController extends Controller
{
    public function index(request $request)
    {
        if($request->ajax()) {
            $contact_us = ContactUs::select('*');
            return Datatables::of($contact_us)
                ->addColumn('action', function ($contact_us) {
                    return '
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $contact_us->id . '" data-title="' . $contact_us->name . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('created_at', function ($user) {
                    return $user->created_at ? with(new Carbon($user->created_at))->format('m/d/Y') : '';
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%m/%d/%Y') like ?", ["%$keyword%"]);
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin.contact_us.index');
        }
    } //end of index

    public function delete(Request $request)
    {
        $contact_us = ContactUs::where('id', $request->id)->first();

            $contact_us->delete();
            return response(['message'=>'تم الحذف بنجاح','status'=>200],200);

    } //end of delete

} //end class
