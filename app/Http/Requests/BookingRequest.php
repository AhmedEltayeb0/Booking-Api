<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'customr_id'=> 'required|integer|exists:customrs,id',
            'room_id'=> 'required|exists:rooms,id',
            'booking_date'=> 'required|date_format:Y-m-d H:i',
            'from'=> 'required|date_format:Y-m-d H:i',
            'to'=> 'required|date_format:Y-m-d H:i',

        ];
    }
}
