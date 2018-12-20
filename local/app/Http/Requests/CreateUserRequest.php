<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'password' => 'min:8|required_with:password_confirm|same:password_confirm',
            'password_confirm' =>'min:8',
            'email' => 'unique:guest_users',
            'avatar' => 'image|mimes:jpg,png,jpeg|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'password.min' => 'Password tối thiểu 8 ký tự',
            'password.same' => 'Password không khớp nhau',
            'email.unique' => 'Email đã tồn tại'
        ];
    }
}
