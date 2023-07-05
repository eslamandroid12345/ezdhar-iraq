<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSubCategory extends FormRequest
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
            'category_id'      => 'required',
            'title_ar'      => 'required',
            'title_en'      => 'required',
            'terms_ar'      => 'nullable',
            'terms_en'      => 'nullable',
            'image'     => 'mimes:jpeg,jpg,png,gif,webp',
        ];
    }

    public function messages()
    {
        return [
            'image.mimes'                => 'صيغة الصورة غير مسموحة',
            'title_ar.required'              => 'يجب ادخال الاسم',
            'title_en.required'              => 'يجب ادخال الاسم',
//            'terms_ar.required'              => 'يجب ادخال الشروط',
//            'terms_en.required'              => 'يجب ادخال الشروط',
            'category_id.required'              => 'يجب ادخال القسم',
        ];
    }
}
