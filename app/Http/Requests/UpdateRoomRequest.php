<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
        $room = $this->route('room');
        $roomId = $room ? $room->id : null;

        return [
            'room_no' => 'required|string|max:255|unique:rooms,room_no,' . $roomId,
            'building' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'room_type' => 'required|in:0,1',
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
            'room_no.required' => 'Enter Room No',
            'room_no.unique' => 'Room no already exist',
            'capacity.required' => 'Enter Capacity',
            'building.required' => 'Enter Building Name',
        ];
    }
}
