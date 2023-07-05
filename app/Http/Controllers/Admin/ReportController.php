<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderReport;
use App\Models\Report;
use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Traits\PhotoTrait;


class ReportController extends Controller
{
    use PhotoTrait;
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $reports = OrderReport::latest()->get();
            return Datatables::of($reports)
                ->addColumn('action', function ($reports) {
                    return '
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $reports->id . '" data-title="">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('user_id', function ($data){
                    return $data->user->first_name;
                })
                ->editColumn('provider_id', function ($data){
                    return $data->provider->first_name;
                })
                ->editColumn('order_id', function($reports){
                    return '<button type="button" data-id="' . $reports->order_id . '"
                                    class="btn btn-pill btn-primary-light showBtn">
                                    <i class="fas fa-window-maximize"></i> عرض
                                </button>';
                })
                ->editColumn('created_at', function ($data){
                    return $data->created_at->format('m/d/Y');
                })
                ->editColumn('img', function ($reports) {
                    if ($reports->img == null){
                            return  'No Data';
                    } else {


                        return '
                    <img alt="image" onclick="window.open(this.src)" class="avatar avatar-md rounded-circle" src="' . asset($reports->img) . '">
                    ';
                    }
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('Admin.report.index');
        }
    } //end of index

    public function order(Request $request)
    {

            $order = ServiceRequest::find($request->id);

            return view('Admin.report.services_index', compact('order'));

    }

    public function delete(Request $request)
    {
        $services = OrderReport::where('id', $request->id)->first();
        $services->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);

    } // end delete
}
