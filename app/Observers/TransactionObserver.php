<?php

namespace App\Observers;

use App\Models\Transaction;
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
