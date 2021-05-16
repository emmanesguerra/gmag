<?php

namespace App\Observers;

use App\Models\TransactionEncashment;
use App\Library\Modules\TransactionLibrary;
use Illuminate\Support\Facades\Auth;

class TransactionEncashmentObserver
{
    //
    /**
     * Listen to the Transaction creating event.
     *
     * @param  \App\Models\Transaction  $args
     * @return void
     */
    public function creating(TransactionEncashment $args)
    {
        $args->created_by = Auth::id();
        $args->transaction_no = TransactionLibrary::getNextSequence('ER');
    }
    
    /**
     * Listen to the Transaction updating event.
     *
     * @param  \App\Models\Transaction  $args
     * @return void
     */
    public function updating(TransactionEncashment $args)
    {
        $args->updated_by = Auth::id();
    }
}
