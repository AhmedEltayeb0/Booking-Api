<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        
            'name'=> 'required',
            'age'=> 'integer|max:150',
            'gender'=> 'string|required',
            'phone'=> 'string|numeric|required|unique:users,phone',
            'email'=> 'email|unique:users,email',
            'password'=> 'string|required|confirmed',
            'password_confirmation' =>'required',
            
            //
        ];
    }
}
