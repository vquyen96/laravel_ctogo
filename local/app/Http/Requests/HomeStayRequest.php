<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeStayRequest extends FormRequest
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
           'homestay_name' => 'required|max:50'
        ];
    }
    public function messages()
    {
        return [
            'homestay_name.max' => 'Không được quá 50 ký tự'
        ];
        
    }
}
