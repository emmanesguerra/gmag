<?php

namespace App\Observers;

use App\Models\MembersRegistrationCode;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class MembersRegistrationCodeObserver
{  
    /**
     * Listen to the MembersRegistrationCode updating event.
     *
     * @param  \App\Models\MembersRegistrationCode  $args
     * @return void
     */
    public function updating(MembersRegistrationCode $args)
    {
        $args->updated_by = Auth::id();
    }
}
