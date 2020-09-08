<?php

namespace App\Http\Requests\Admission;

use Illuminate\Foundation\Http\FormRequest;

class StudentMultipleUpload extends FormRequest
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
            'file_name.*'=>'required',
            'file.*'=>'required|mimes:doc,pdf,docx,jpg,jpeg,png,gif|mimetypes:application/msword', //zip
        ];
    }
}
