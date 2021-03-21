<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
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
            'type' => 'required',
            'code' => 'required|unique:products,code',
            'name' => 'required|unique:products,name',
            'price' => 'required|numeric',
            'pv' => 'required|numeric',
            'upv' => 'required|numeric',
            'registration_code_prefix' => 'required|max:2|unique:products,registration_code_prefix'
        ];
    }
    
    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'upv.required' => 'UPoints value is required',
            'pv.required' => 'Points value is required'
        ];
    }
}
