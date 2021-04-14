<?php

namespace App\Observers;

use App\Models\Member;
use Illuminate\Support\Facades\Auth;


class MemberObserver
{  
    //
    /**
     * Listen to the Member creating event.
     *
     * @param  \App\Models\Member  $args
     * @return void
     */
    public function creating(Member $args)
    {
        $args->created_by = (Auth::check()) ? Auth::id(): 0;
        $args->referral_code = substr(strtoupper(bin2hex(random_bytes(10))), 0, 16);
    }
    
    /**
     * Listen to the Member updating event.
     *
     * @param  \App\Models\Member  $args
     * @return void
     */
    public function updating(Member $args)
    {
        $args->updated_by = (Auth::check()) ? Auth::id(): 0;
    }
}
