<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;

class VehicleRootMapRequest extends FormRequest
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
             'root_id'      =>  ['required', 'integer', Rule::unique('vehicle_root_maps')->where(function ($query) use ($input) {
                                        return $query->where('vehicle_id', $input['vehicle_id']);
                                    })->ignore($input['vehicle_root_map_id'])], 
            'vehicle_type_id' => 'required|integer',
            'vehicle_id' => 'required|integer',
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
            'root_id.unique'   => 'Root Allready Added this vehicle!',
        ];
    }
}
