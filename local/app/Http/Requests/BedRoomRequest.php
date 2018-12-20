<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BedRoomRequest extends FormRequest
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
           'bedroom_description' => 'required|min:100'
        ];

    }
    public function messages()
    {
        return [
            
        ];
        
    }
}
