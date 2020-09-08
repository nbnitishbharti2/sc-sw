<?php

namespace App\Http\Requests\Admission;

use Illuminate\Foundation\Http\FormRequest;

class StudentTransport extends FormRequest
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
            'root_id'         =>  'required|integer',
            'vehicle_type_id' =>  'required|integer',
            'vehicle_id'      =>  'required|integer',
            'stopage_id'      =>  'required|integer',
            'amount'          =>  'required|integer',
            
        ];
    }
}
