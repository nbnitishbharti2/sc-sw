<?php

namespace App\Http\Requests\Admission;

use Illuminate\Foundation\Http\FormRequest;

class StudentAdmission extends FormRequest
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
            'session'       =>  'required',
            'class'         =>  'required',
            'section'       =>  'required',
            'gender'        =>  'required',
            'category'      =>  'required',
            'blood_group'   =>  'required',
            'admission_no'  =>  'required|integer',
            'roll_no'       =>  'required|integer',
            'name'          =>  'required|string|max:190|min:3',
            'dob'           =>  'required', 
            'mobile_no'     =>  'required|digits:10',
            'email'         =>  'required|email',
            'aadhar_no'     =>  'required|digits:12',
            'siblings'      =>  'required|integer',
            'cast'          =>  'nullable|string',
            'image'         =>  'nullable|image|mimes:jpg,jpeg,png',
        ];
    }
}
