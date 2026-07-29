<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
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
        $department = $this->route('department');
        $departmentId = $department ? $department->id : null;

        return [
            'department_name' => 'required|string|max:255|unique:departments,department_name,' . $departmentId,
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
            'department_name.required' => 'Enter Department Name',
            'department_name.unique' => 'Department already exists',
        ];
    }
}
