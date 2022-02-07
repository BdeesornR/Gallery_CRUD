<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GalleryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file.*' => ['required', 'image', 'mimes:jpg,png', 'max:10000'],
        ];
    }

    public function messages()
    {
        return [
            'file.*.required' => 'Some image is required for upload',
            'file.*.image' => 'Uploaded files must be images',
            'file.*.mimes' => 'Uploaded images must be of type jpg or png',
            'file.*.max' => 'Uploaded image must not exceed 10 kilobytes',
        ];
    }
}
