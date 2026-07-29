<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBatchRequest extends FormRequest
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
            'batch_no' => 'required|string|max:255',
            'shift_id' => 'required|exists:shifts,id',
            'department_id' => 'required|exists:departments,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'batch_no.required' => 'Enter batch',
            'shift_id.required' => 'Enter Shift',
            'department_id.required' => 'Enter Department',
        ];
    }
}
