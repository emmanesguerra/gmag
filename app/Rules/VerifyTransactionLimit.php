<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class VerifyTransactionLimit implements Rule
{
    public $method;
    public $transactionLimit;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($method)
    {
        $this->method = $method;
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
        $dmethod = DB::table('paynamics_disbursement_methods')->select('transaction_limit')->where('method', $this->method)->first();
        if($dmethod) {
            if($dmethod->transaction_limit >= $value) {
                return true;
            }
        }
        $this->transactionLimit = ($dmethod) ? $dmethod->transaction_limit: 0;
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The transaction limit for ' . $this->method . ' must be lessthan or equal to ' . $this->transactionLimit;
    }
}
