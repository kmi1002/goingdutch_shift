<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

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
        // 소문자(a-z), 대문자(A-Z), 숫자(0-9), 특수 문자(!, $, #, %)
        return [
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:6|max:50|confirmed',
            'password_confirmation' => 'required_with:password|same:password',
            'name'                  => 'required|string|unique:users,nick_name|min:3|max:50'
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
            'email.required'                        => Lang::get('auth.alert.empty_email'),
            'email.email'                           => Lang::get('auth.alert.format_email'),
            'email.unique'                          => Lang::get('auth.alert.exist_email'),
            'password.required'                     => Lang::get('auth.alert.empty_password'),
            'password.string'                       => Lang::get('auth.alert.format_password'),
            'password.min'                          => Lang::get('auth.alert.length_password'),
            'password.max'                          => Lang::get('auth.alert.length_password'),
            'password.regex'                        => Lang::get('auth.alert.validation_password'),
            'password_confirmation.required_with'   => Lang::get('auth.alert.empty_password_confirm'),
            'password_confirmation.same'            => Lang::get('auth.alert.different_password'),
            'name.required'                         => Lang::get('auth.alert.empty_nickname'),
            'name.unique'                           => Lang::get('auth.alert.exist_nickname'),
            'name.min'                              => Lang::get('auth.alert.length_nickname'),
            'name.max'                              => Lang::get('auth.alert.length_nickname'),
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