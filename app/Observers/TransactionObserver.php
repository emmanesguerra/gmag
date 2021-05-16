<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Library\Modules\TransactionLibrary;
use Illuminate\Support\Facades\Auth;

class TransactionObserver
{
    //
    /**
     * Listen to the Transaction creating event.
     *
     * @param  \App\Models\Transaction  $args
     * @return void
     */
    public function creating(Transaction $args)
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
     * Listen to the Transaction updating event.
     *
     * @param  \App\Models\Transaction  $args
     * @return void
     */
    public function updating(Transaction $args)
    {
        $args->updated_by = Auth::id();
    }
}
