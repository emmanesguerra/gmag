<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\MemberLog;
use Illuminate\Support\Facades\Auth;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Login $event)
    {
        try
        {
            if(Auth::guard('web')->check()) {
                DB::beginTransaction();

                $member = $event->user;

                $userlog = MemberLog::create(['log_in' => \Carbon\Carbon::now(), 'ip_address' => $this->request->ip(), 'username' => $member->username]);

                if($userlog) {
                    $member->disableAuditing();
                    $member->ip_address = $this->request->ip();
                    $member->curr_login_id = $userlog->id;
                    $member->save();
                }

                DB::commit();
            }
        } catch (\Exception $ex) {
            DB::rollback();
            Log::error($ex->getMessage());
        }
    }
}
