<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
        $course = $this->route('course');
        $courseId = $course ? $course->id : null;

        return [
            'course_name' => 'required|string|max:255|unique:courses,course_name,' . $courseId,
            'course_code' => 'required|string|max:255|unique:courses,course_code,' . $courseId,
            'credit' => 'required|numeric|min:0.5',
            'course_type' => 'required|in:0,1',
            'is_active' => 'required|in:yes,no',
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
            'course_name.required' => 'Enter course name',
            'course_name.unique' => 'Course already exists',
            'course_code.required' => 'Enter course code',
            'course_code.unique' => 'Course code already exists',
            'credit.required' => 'Enter course credit',
        ];
    }
}
