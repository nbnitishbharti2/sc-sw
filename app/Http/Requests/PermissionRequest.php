<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
class PermissionRequest extends FormRequest
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
            'module_id'     => ['required', 'integer', Rule::unique('permissions')->where(function ($query) use ($input) {
                                return $query->where('module_id', $input['module_id'])->where('name', $input['name']);
                            })], 
            'name'           => 'required|string|max:255',
            'description'    => 'required|string',
        ];
    }
}
