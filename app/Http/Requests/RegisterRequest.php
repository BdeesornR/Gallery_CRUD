<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:8'],
            'email' => ['required', 'string', 'email:rfc,dns,spoof', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'different:name', 'different:email', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'A name is required',
            'name.min' => 'Name must be at least 8 characters',

            'email.required' => 'An email is required',
            'email.email' => 'This email might not legitimate',
            'email.unique' => 'This email is already exists',

            'password.required' => 'A password is required',
            'password.min' => 'Password must be at least 6 characters',
            'password.different' => 'Password must different from name or email',
            'password.confirmed' => 'Passwords are not matched',

            'password_confirmation.required' => 'Password Confirmation is required',
        ];
    }
}
