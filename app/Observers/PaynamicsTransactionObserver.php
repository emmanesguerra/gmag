<?php

namespace App\Observers;

use App\Models\PaynamicsTransaction;
use Illuminate\Support\Facades\Auth;

class PaynamicsTransactionObserver
{
    //
    /**
     * Listen to the PaynamicsTransaction creating event.
     *
     * @param  \App\Models\PaynamicsTransaction  $args
     * @return void
     */
    public function creating(PaynamicsTransaction $args)
    {
        $args->created_by = Auth::id();
        $args->transaction_no = substr(strtoupper(bin2hex(random_bytes(10))), 0, 15);
    }
    
    /**
     * Listen to the PaynamicsTransaction updating event.
     *
     * @param  \App\Models\PaynamicsTransaction  $args
     * @return void
     */
    public function updating(PaynamicsTransaction $args)
    {
        $args->updated_by = Auth::id();
    }
}
