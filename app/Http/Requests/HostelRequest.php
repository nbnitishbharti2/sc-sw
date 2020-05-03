<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HostelRequest extends FormRequest
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
            'name' => 'required|string|max:190|min:3',
            'address' => 'required|string|max:255',
            'facilities_ids' => 'required',
            'no_of_rooms'=>'required|integer|min:1',
            'warden_name'=>'required|string|max:190|min:3'
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

        ];
    }
}
