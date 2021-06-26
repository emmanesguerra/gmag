<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EncashmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::guard('web')->check()) {
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
            'source' => 'required',
            'amount' => 'required|gte:minimum_req|lte:source_amount',
            'disbursement_method' => 'required',
            'firstname' => 'required|string|max:50',
            'middlename' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address1' => 'required|string|max:50',
            'address2' => 'nullable|string|max:50',
            'city' => 'required|string|max:20',
            'state' => 'nullable|string|max:20',
            'country' => 'required|string|max:2',
            'zip' => 'nullable|string|max:10',
            'mobile' => 'required|numeric',
            'email' => 'required|email',
            'password' => 'required|verifypassword'
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
            'password.verifypassword' => "Password is incorrect",
        ];
    }
}
