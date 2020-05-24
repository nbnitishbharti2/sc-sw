<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeeForClassRequest extends FormRequest
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
            'class_id.*' => 'nullable|integer', 
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
