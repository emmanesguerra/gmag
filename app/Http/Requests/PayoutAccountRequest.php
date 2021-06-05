<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PayoutAccountRequest extends FormRequest
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
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'required|string|max:35',
            'middlename' => 'required|string|max:35',
            'lastname' => 'required|string|max:50',
            'birthdate' => 'required|date',
            'birthplace' => 'required|string|max:50',
            'email' => 'required|string|email|max:191',
            'mobile' => 'required|numeric',
            'address1' => 'required|string|max:50',
            'address2' => 'nullable|string|max:50',
            'address3' => 'nullable|string|max:50',
            'city' => 'required|string|max:20',
            'state' => 'nullable|string|max:20',
            'country' => 'required|string|max:2',
            'zip' => 'nullable|string|max:10',
            'nationality' => 'required|string|max:50',
            'nature_of_work' => 'required|string|max:50',
            'document.*.doc' => 'nullable|string|max:7|exists:document_options,code',
            'document.*.idnum' => 'required_with:document.*.doc|max:100',
            'document.*.exp' => 'required_with:document.*.doc',
        ];
    }
    
    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        
        $messages = [];
        foreach ($this->request->get('document') as $line => $requestData) {
            foreach ($requestData as $input => $value) {
                $messages['document.' . $line . '.idnum.required_with'] = 'Document ID Number on box ' . ($line + 1)  . '  is required';
                $messages['document.' . $line . '.exp.required_with'] = 'Document Expiry Date on box ' . ($line + 1)  . '  is required';
            }
        }
        return $messages;
    }
}
