<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRegistrationRequest extends FormRequest
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
            'username' => 'required|string|max:50',
            'password' => 'required|string|min:5|confirmed',
            'sponsor' => 'required|string|exists:members,username',
            'placement' => 'required|string|exists:members,username',
            'position' => 'required|in:L,R|verifyavailableposition:placement',
            'firstname' => 'required|string|max:50',
            'middlename' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => 'required|string|max:150',
            'email' => 'required|string|email|max:191|unique:members,email',
            'mobile' => 'required|numeric',
            'pincode1' => 'required|string|exists:registration_codes,pincode1',
            'pincode2' => 'required|string|exists:registration_codes,pincode2',
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
            'position.verifyavailableposition' => 'The position for this placement is already taken',
        ];
    }
}
