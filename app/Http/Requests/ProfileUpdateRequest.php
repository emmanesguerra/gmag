<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
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
        $memberid = $this->route()->id;
        
        return [
            'birthdate' => 'required|date',
            'email' => 'required|string|email|max:191|unique:members,email,'.$memberid,
            'mobile' => 'required|numeric',
            'address' => 'required|string|max:150',
        ];
    }
}
