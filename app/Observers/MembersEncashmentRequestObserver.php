<?php

namespace App\Observers;

use App\Models\MembersEncashmentRequest;
use Illuminate\Support\Facades\Auth;

class MembersEncashmentRequestObserver
{
    //
    /**
     * Listen to the Transaction creating event.
     *
     * @param  \App\Models\Transaction  $args
     * @return void
     */
    public function creating(MembersEncashmentRequest $args)
    {
        $args->created_by = Auth::id();
    }
    
    /**
     * Listen to the Transaction updating event.
     *
     * @param  \App\Models\Transaction  $args
     * @return void
     */
    public function updating(MembersEncashmentRequest $args)
    {
        $args->updated_by = Auth::id();
    }
}
