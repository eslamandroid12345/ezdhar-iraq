<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategory extends FormRequest
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
            'title_ar'      => 'required',
            'title_en'      => 'required',
            'limit'      => 'required|numeric',
            'image'     => 'mimes:jpeg,jpg,png,gif,webp',
        ];
    }

    public function messages()
    {
        return [
            'image.mimes'                => 'صيغة الصورة غير مسموحة',
            'title_ar.required'              => 'يجب إدخال الاسم',
            'title_en.required'              => 'يجب إدخال الاسم',
            'limit.required'              => 'يجب إدخال عدد الطلبات',
            'limit.numeric'              => 'يجب إدخال عدد الطلبات أرقام',
        ];
    }
}
