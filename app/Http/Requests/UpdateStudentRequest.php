<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
        $student = $this->route('student');
        $studentId = $student ? $student->id : null;

        return [
            'number_of_student' => 'required|integer|min:1',
            'batch_id' => 'required|exists:batch,id|unique:students,batch_id,' . $studentId,
            'yearly_session_id' => 'required|exists:yearly_sessions,id',
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
            'number_of_student.required' => 'Enter number of students',
            'batch_id.unique' => 'Data already exists for this batch',
        ];
    }
}
