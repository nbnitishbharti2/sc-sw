<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Http\FormRequest;

class BloodGroupRequest extends FormRequest
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
        $input = Input::all();
        return [
            'name' => 'required|string|max:190|min:3|unique:blood_groups,name,'.$input['blood_group_id'].',id'
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
