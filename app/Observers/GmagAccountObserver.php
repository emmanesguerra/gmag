<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Models\GmagAccount;

class GmagAccountObserver
{
    //
    /**
     * Listen to the GmagAccount creating event.
     *
     * @param  \App\Models\GmagAccount  $args
     * @return void
     */
    public function creating(GmagAccount $args)
    {
        $args->created_by = (Auth::check()) ? Auth::id(): 0;
    }
    
    /**
     * Listen to the GmagAccount updating event.
     *
     * @param  \App\Models\GmagAccount  $args
     * @return void
     */
    public function updating(GmagAccount $args)
    {
        $args->updated_by = (Auth::check()) ? Auth::id(): 0;
    }
}
