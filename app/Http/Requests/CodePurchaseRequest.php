<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CodePurchaseRequest extends FormRequest
{
    protected $redirect  = "code-vault/purchase#payment_form";
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
            "product" => "required",
            "quantity" => "required",
            "total_amount" => "required|verifytotalamount:quantity,product",
            "payment_method" => "required",
            "payinmethod_name" => "required_if:payment_method,paynamics",
            "source" => "required_if:payment_method,ewallet",
            "source_amount" => 'required_if:payment_method,ewallet'
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
            'total_amount.verifytotalamount' => "The total amount doesn't match with the system's computation. Please refresh your browser and resend the request",
            'payinmethod_name.required_if' => "Please select atleast one pay in method"
        ];
    }
}
