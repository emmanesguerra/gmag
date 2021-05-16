<?php

namespace App\Observers;

use App\Models\HonoraryMember;
use Illuminate\Support\Facades\Auth;


class HonoraryMemberObserver
{  
    //
    /**
     * Listen to the HonoraryMember creating event.
     *
     * @param  \App\Models\HonoraryMember  $args
     * @return void
     */
    public function creating(HonoraryMember $args)
    {
        $args->created_by = (Auth::check()) ? Auth::id(): 0;
    }
    
    /**
     * Listen to the HonoraryMember updating event.
     *
     * @param  \App\Models\HonoraryMember  $args
     * @return void
     */
    public function updating(HonoraryMember $args)
    {
        $args->updated_by = (Auth::check()) ? Auth::id(): 0;
    }
}
