<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RegisterMemberRequest extends FormRequest
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
        } else if(Auth::guard('admin')->check()) {
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
            'username' => 'required|string|max:50',
            'sponsor' => 'required|string|exists:members,username',
            'placement' => 'required|string|exists:members,username',
            'position' => 'required|in:L,R',
            'firstname' => 'required|string|max:35',
            'middlename' => 'required|string|max:35',
            'lastname' => 'required|string|max:50',
            'address' => 'required|string|max:150',
            'email' => 'required|string|email|max:191|unique:members,email',
            'mobile' => 'required|numeric',
            'pincode1' => 'required|string|exists:registration_codes,pincode1',
            'pincode2' => 'required|string|exists:registration_codes,pincode2',
        ];
    }
}
