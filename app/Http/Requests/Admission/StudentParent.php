<?php

namespace App\Http\Requests\Admission;

use Illuminate\Foundation\Http\FormRequest;

class StudentParent extends FormRequest
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
            'father_name'=>'required',
            'father_mobile_no'=>'nullable|digits:10',
            'father_occupation'=>'required',
            'father_education' =>'required',
            'mother_name'=>'required',
            'mother_mobile_no'=>'nullable|digits:10',
            'mother_occupation'=>'required',
            'mother_education'=>'required',
        ];
    }
}
