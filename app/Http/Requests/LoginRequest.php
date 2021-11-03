<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => ['required', 'string', 'email:rfc,dns,spoof', 'exists:users,email'],
            'password' => ['required', 'string', 'min:6', 'different:email'],
            'persist' => ['required', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'An email is required',
            'email.email' => 'This email might not legitimate',
            'email.exists' => 'This email is not exists',

            'password.required' => 'A password is required',
            'password.min' => 'Password must be at least 6 characters',
            'password.different' => 'Password must different from email',
        ];
    }
}
