<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

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
            'email'     => 'required|email',
            'password'  => 'required|string|min:6|max:50',
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
            'email.required'        => Lang::get('auth.alert.empty_email'),
            'email.email'           => Lang::get('auth.alert.format_email'),
            'password.required'     => Lang::get('auth.alert.empty_password'),
            'password.string'       => Lang::get('auth.alert.format_password'),
            'password.min'          => Lang::get('auth.alert.length_password'),
            'password.max'          => Lang::get('auth.alert.length_password'),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }
}
