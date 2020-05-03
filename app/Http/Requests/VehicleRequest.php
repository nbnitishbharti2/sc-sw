<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
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
            'driver_name' => 'required|string|max:190|min:3',
            'driver_contact_no' => 'required|numeric|digits:10|unique:vehicles,driver_contact_no,'.$input['vehicle_id'].',id',
            'helper_name' => 'required|string|max:190|min:3',
            'helper_contact_no' => 'required|numeric|digits:10|unique:vehicles,helper_contact_no,'.$input['vehicle_id'].',id',
            'vehicle_type_id' => 'required|integer|max:11',
            'vehicle_no' => 'required|string|unique:vehicles,vehicle_no,'.$input['vehicle_id'].',id'
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
