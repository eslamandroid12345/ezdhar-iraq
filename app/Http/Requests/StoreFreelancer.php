<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFreelancer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'image',
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'phone_code' => 'required|max:5',
            'phone' => 'required|numeric',
            'email' => "required|email|unique:users,email",
            'category_id' => 'required',
            'city_id' => 'required',
            'birthdate' => 'required',
            'years_ex' => 'required|numeric',
            'bio' => 'required',
        ];
    }

    public function messages()
    {
        return [
//            'image.required' => 'يرجي رفع لوجو او صورة لمقدم الخدمة',
            'image.image' => ' صورة لمقدم الخدمة يجب ان تكون صورة',

            'first_name.required' => 'يرجي ادخال الاسم الاول',
            'last_name.required' => 'يرجي ادخال الاسم الاخير',

            'phone_code.required' => 'يرجي ادخال كود الدولة ',
//            'phone_code.numeric' => ' كود الدولة يجب ان يكون رقما ',
            'phone.required' => 'يرجي ادخال الهاتف',
            'phone.numeric' => 'الهاتف يجب ان يكون رقما',

            'email.required' => 'يرجي ادخال البريد الاكتروني',
            'email.email' => 'البريد الاكتروني غير صالح',
            'email.unique' => 'البريد الاكتروني مستخدم من قبل',

            'category_id.required' => 'يرجي اختيار القسم ',

            'city_id.required' => 'يرجي اختيار المدينة ',

            'birthdate.required' => 'يرجي ادخال تاريخ الميلاد ',

            'years_ex.required' => 'يرجي ادخال سنين الخبرة',
            'years_ex.numeric' => 'سنين الخبرة يجب ان يكون رقما',

            'bio.required' => 'يرجي ادخال الوصف',
        ];
    }
}
