<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassRequest extends FormRequest
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
            'class_name' => 'required|string|max:50|min:1|unique:classes',
            'class_short' => 'required|string|max:50|unique:classes|min:1',
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
            'class_name.unique' => 'Class Name is already Saved!',
            'class_short.unique' => 'Class Short Name is already Saved!',
        ];
    }
}
