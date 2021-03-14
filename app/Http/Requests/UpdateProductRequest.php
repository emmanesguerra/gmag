<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        $productid = $this->route()->id;
        
        return [
            'id' => 'required',
            'type' => 'required',
            'code' => 'required|unique:products,code,'.$productid,
            'name' => 'required|unique:products,name,'.$productid,
            'price' => 'required|numeric',
            'pv' => 'required|numeric',
            'upv' => 'required|numeric'
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
