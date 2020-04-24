<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;

class SectionRequest extends FormRequest
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
            'class_id'          => 'required|integer',
            'section_name'      =>  ['required', 'string', 'max:50', 'min:1', Rule::unique('sections')->where(function ($query) use ($input) {
                                        return $query->where('session_id', 1)->where('classes_id', $input['class_id']);
                                    })->ignore($input['section_id'])],
            'section_short'     =>  ['required', 'string', 'max:50', 'min:1', Rule::unique('sections')->where(function ($query) use ($input) {
                                    return $query->where('session_id', 1)->where('classes_id', $input['class_id']);
                                })->ignore($input['section_id'])],
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
            'class_id.required'     => 'Class is Required',
            'class_id.integer'      => 'Oops! Something wrong with Class',
            'section_name.unique'   => 'Section Name is already Saved for this Session or Class!',
            'section_short.unique'  => 'Section Short Name is already Saved for this Session or Class!',
        ];
    }
}
