<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest; 
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
use Session;
class StopageRequest extends FormRequest
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
            'stopage_name'      =>  ['required', 'string','max:190', Rule::unique('stopages')->where(function ($query) use ($input) {
                                        return $query->where('root_id', $input['root_id'])->where('vehicle_type_id', $input['vehicle_type_id'])->where('vehicle_id', $input['vehicle_id'])->where('session_id', Session::get('session'));
                                    })->ignore($input['stopage_id'])], 
            'root_id' => 'required|integer',
            'vehicle_type_id' => 'required|integer',
            'vehicle_id' => 'required|integer|',
            'charge' => 'required|integer',
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
