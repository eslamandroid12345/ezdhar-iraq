<?php

namespace App\Http\Controllers\Api\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\Http\Resources\ContactUsResources;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller{



    public function all(){

        $contacts = ContactUs::get();

        return returnDataSuccess("Contacts get successfully","200","contacts",ContactUsResources::collection($contacts));
    }



    public function store(Request $request){

        $rules = [

            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',

        ];


        $messages = [

            'name.required' => 'اسم المستخدم مطلوب',
            'email.required' => 'البريد الالكتروني مطلوب',
            'email.email' => 'البريد الالكتروني للمستخدم يجب ان يكون ايميل',
            'subject.required' => 'الموضوع مطلوب',
            'message.required' => 'الرساله مطلوبه',


        ];

        $validator = Validator::make($request->all(),$rules,$messages);

        if ($validator->fails()){

            return returnMessageError($validator->errors(),500);
        }

        $contact =  new ContactUs();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();

        if($contact){

            return returnDataSuccess("تم تسجيل البيانات بنجاح",201,"contact",new ContactUsResources($contact));
        }

    }


}

