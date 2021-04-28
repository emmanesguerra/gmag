<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use App\Models\MemberLog;

class LogSuccessfulLogout
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        if(Auth::guard('web')->check()) {
            $member = $event->user;

            $userlog = MemberLog::find($member->curr_login_id);
            $userlog->log_out = \Carbon\Carbon::now();
            $userlog->save();
        }
    }
}
