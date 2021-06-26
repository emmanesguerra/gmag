<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class VerifyBankNo implements Rule
{
    public $method;
    public $bankCode;
    public $length;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($method, $bankCode)
    {
        $this->method = $method;
        $this->bankCode = $bankCode;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $dmethod = DB::table('paynamics_disbursement_method_bank_codes')->select('length', 'leading_zeroes')
                                ->where('method', $this->method)
                                ->where('code', $this->bankCode)
                                ->first();
        if($dmethod) {
            if($dmethod->leading_zeroes) {
                return true;
            } else {
                $length = explode(',', $dmethod->length);
                if(in_array(strlen($value), $length)) {
                    return true;
                }
            }
        }
        $this->length = (isset($length)) ? $length: [];
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if(!empty($this->length)) {
            return 'Invalid bank account number. Length should be [' . implode(' or ', $this->length) . '] digits';
        } else {
            return 'Invalid bank account number. ';
        }
        
    }
}
