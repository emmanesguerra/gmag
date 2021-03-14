<?php

namespace App\Observers;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class SettingsObserver
{
    //
    /**
     * Listen to the Setting creating event.
     *
     * @param  \App\Models\Setting  $args
     * @return void
     */
    public function creating(Setting $args)
    {
        $args->created_by = Auth::id();
    }
    
    /**
     * Listen to the Setting updating event.
     *
     * @param  \App\Models\Setting  $args
     * @return void
     */
    public function updating(Setting $args)
    {
        $args->updated_by = Auth::id();
    }
}
