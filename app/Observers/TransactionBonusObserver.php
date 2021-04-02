<?php

namespace App\Observers;

use App\Models\TransactionBonus;
use Illuminate\Support\Facades\Auth;

class TransactionBonusObserver
{
    //
    /**
     * Listen to the TransactionBonus creating event.
     *
     * @param  \App\Models\TransactionBonus  $args
     * @return void
     */
    public function creating(TransactionBonus $args)
    {
        $args->created_by = Auth::id();
    }
    
    /**
     * Listen to the TransactionBonus updating event.
     *
     * @param  \App\Models\TransactionBonus  $args
     * @return void
     */
    public function updating(TransactionBonus $args)
    {
        $args->updated_by = Auth::id();
    }
}
