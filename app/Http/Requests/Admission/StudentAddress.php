<?php

namespace App\Http\Requests\Admission;

use Illuminate\Foundation\Http\FormRequest;

class StudentAddress extends FormRequest
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
            'country'=>'required',
            'state'=>'required',
            'district'=>'required',
            'city' =>'required',
            'address'=>'required|string|max:255',
            'pin_code'=>'required|digits:6',
        ];
    }
}
