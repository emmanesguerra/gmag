<?php

namespace App\Observers;

use App\Models\PaynamicsTransaction;
use Illuminate\Support\Facades\Auth;
use App\Library\Modules\TransactionLibrary;

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
        switch($args->transaction_type) {
            case "Credit Adj":
                $args->transaction_no = TransactionLibrary::getNextSequence('CA');
                break;
            case "Purchase":
                $args->transaction_no = TransactionLibrary::getNextSequence('PP');
                break;
            case "Activation":
                $args->transaction_no = TransactionLibrary::getNextSequence('AT');
                break;
        }
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
