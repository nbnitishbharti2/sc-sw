<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'school_name' => 'required|min:2|string',
            'school_short_name' => 'required|min:1|string',
            'address' => 'required|string',
            'mobile_no' => 'required|digits:10',
            'mobile_no_2' => 'nullable|digits:10',
            'phone_no' => 'nullable|min:5',
            'pin_code' => 'required|digits:6',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'country_code' => 'required|min:2|string',
            'country_phone_code' => 'required|min:3|string',
            'currency' => 'required|string',
            'web_site' => 'required',
            'email' => 'required|email',
            'logo' => 'nullable|image',
            'water_mark' => 'nullable|image', 
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
           /* 'school_name.required' => trans('validation.required'),
            'school_name.min' => trans('validation.min.numeric'),
            'school_short_name.required'=>trans('validation.required'),
            'school_short_name.min'=>trans('validation.min.numeric'),
            'address.required' => trans('validation.required'),
            'mobile_no.required' => trans('validation.required'),
            'mobile_no.digits' => trans('validation.digits'),
            'mobile_no2.required' => trans('validation.required'),
            'mobile_no2.digits' => trans('validation.digits'),
            'phone_no.min' => trans('validation.min.numeric'),
            'pin_code.required'=>trans('validation.required'),
            'pin_code.min'=> trans('validation.min.numeric'),
            'city.required' => trans('validation.required'),
            'state.required' => trans('validation.required'),
            'country.required' => trans('validation.required'),
            'country_code.required' => trans('validation.required'),
            'country_code.min' => trans('validation.min.numeric'), 
            'country_phone_code.required' => trans('validation.required'),
            'country_phone_code.min' => trans('validation.min.numeric'),
            'currency.required' => trans('validation.required'),
            'web_site.required' => trans('validation.required'),
            'email.required' => trans('validation.required'),
            'email.email' => trans('validation.email'),
            'logo.image' => trans('validation.image'),
            'water_mark.image' => trans('validation.image'),*/
        ];
    }
}
