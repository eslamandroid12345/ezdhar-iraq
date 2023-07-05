<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\Order;
use App\Models\Project;
use App\Models\User;

class MainController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        $contactus = ContactUs::latest()->limit(4)->get();
        $contact_total = ContactUs::get();
        $category = Category::all();
        $users = User::all();
        $order = Order::all();
        return view('Admin.index',compact([
            'projects',
            'category',
            'users',
            'contactus',
            'contact_total',
            'order'
        ]));
    }
}
