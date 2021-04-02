<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GenerateEntryCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::guard('admin')->check()) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'sometimes|nullable|exists:members,username',
            'product_id' => 'required',
            'code_count' => 'required|numeric|max:5000',
            'administrator_password' => 'required|verifypassword'
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
            'code_count.required' => "The number of codes field is required",
            'code_count.max' => "The number of codes field may not be greater than 100",
            'administrator_password.required' => "The adminstrator's password is required",
            'administrator_password.verifypassword' => "The adminstrator's password is incorrect"
        ];
    }
}
