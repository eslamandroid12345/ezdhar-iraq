<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjects extends FormRequest
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
            'title'             => 'required',
            'text'              => 'required',
            'category_id'       => 'required',
            'ownership_rate'    => 'nullable',
            'success_rate'      => 'nullable',
            'cost'              => 'required',
            'status'            => 'required',
            'image'             => 'mimes:jpeg,jpg,png,gif,webp',
        ];
    }

    public function messages()
    {
        return [
            'image.mimes'                       => 'صيغة الصورة غير مسموحة',
            'text.required'                     => 'يجب ادخال الوصف',
            'category_id.required'              => 'يجب ادخال القسم',
            'cost.required'                     => 'يجب ادخال التكلفة',
            'status.required'                   => 'يجب ادخال الحالة',
            'title.required'                    => 'يجب ادخال الاسم',
        ];
    }
}
