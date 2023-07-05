<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAbout;
use App\Http\Requests\StorePrivacy;
use App\Http\Requests\StoreSetting;
use App\Http\Requests\StoreTerms;
use App\Models\About;
use App\Models\Privacy;
use App\Models\Setting;
use App\Models\Terms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class SettingController extends Controller
{
    public function about(request $request)
    {
        $abouts = Setting::first();
        if ($request->ajax()) {
            $about = Setting::select('*');
            return Datatables::of($about)
                ->addColumn('action', function ($about) {
                    return '
                            <button type="button" data-id="' . $about->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {

            return view('Admin.setting.about.index', compact('abouts'));
        }
    } //end of about

    public function updateabout(StoreAbout $request, $id)
    {
        $inputs = $request->except('id');

        $about = Setting::findOrFail($id);

        if ($about->update($inputs))
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
    } //end of updateabout

    public function terms(request $request)
    {
        $terms = Setting::first();
        if ($request->ajax()) {
            $terms = Setting::select('*');
            return Datatables::of($terms)
                ->addColumn('action', function ($terms) {
                    return '
                            <button type="button" data-id="' . $terms->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('Admin.setting.terms.index', compact('terms'));
        }
    } //end of about

    public function updateterms(StoreTerms $request, $id)
    {
        $inputs = $request->except('id');

        $terms = Setting::findOrFail($id);

        if ($terms->update($inputs))
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
    }

    public function privacy(request $request)
    {
        $privacy = Setting::first();
        if ($request->ajax()) {
            $privacy = Setting::select('*');
            return Datatables::of($privacy)
                ->addColumn('action', function ($privacy) {
                    return '
                            <button type="button" data-id="' . $privacy->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('Admin.setting.privacy.index',compact('privacy'));
        }
    } //end of about

    public function updateprivacy(StorePrivacy $request, $id)
    {
        $inputs = $request->except('id');

        $privacy = Setting::findOrFail($id);

        if ($privacy->update($inputs))
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
    }

    public function edit(Setting $setting)
    {
        return view('Admin.setting.parts.edit', compact('setting'));
    }

    public function update(StoreSetting $request, $id)
    {
        $inputs = $request->except('id');

        $setting = Setting::findOrFail($id);

        if ($setting->update($inputs))
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
    }
} // end class
