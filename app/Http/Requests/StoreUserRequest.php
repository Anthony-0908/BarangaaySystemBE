<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        //   'photo' => 'required|image|mimes:jpeg,png|max:2048', //photo validation
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
          'password' => 'required|string|min:8',
          'phone_no' => 'nullable', 
          'birthdate' => 'required|date',
          'address'=> 'nullable|string|max:255',
          'gender' => 'nullable|in:male,female',
        //   'role' => 'required',
        ];
    }
}
