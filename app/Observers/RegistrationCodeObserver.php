<?php

namespace App\Observers;

use App\Models\RegistrationCode;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class RegistrationCodeObserver
{  
    /**
     * Listen to the RegistrationCode updating event.
     *
     * @param  \App\Models\RegistrationCode  $args
     * @return void
     */
    public function updating(RegistrationCode $args)
    {
        $args->updated_by = Auth::id();
    }
}
