<?php

namespace App\Http\Requests\Admission;

use Illuminate\Foundation\Http\FormRequest;

class StudentHostel extends FormRequest
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
            'session_id'        => 'required|integer',
            'hostel_id'         => 'required|integer',
            'room_id'           => 'required|integer',
            'bed_no'            => 'required|integer',
            'amount'            => 'required|integer',
            'hostel_fee_ids.*'    => 'required|integer',
        ];
    }
}
