<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,user',
            'gender' => 'required|in:1,2',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'department_id' => 'required|exists:departments,id',
            'rank_id' => 'required|exists:teacher_ranks,id',
            'slug' => 'required|string|max:255',
            'join_date' => 'required|date',
            'date_of_birth' => 'required|date',
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
            'email.required' => 'Enter email',
            'username.unique' => 'This username is already taken',
            'email.unique' => 'This email is already registered',
        ];
    }
}
