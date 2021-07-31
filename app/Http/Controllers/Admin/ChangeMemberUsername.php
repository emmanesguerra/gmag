<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ChangeMemberUsernameRequest;
use App\Models\Member;

/**
 * @group Admin/Members Menu
 *
 */
class ChangeMemberUsername extends Controller
{
    /**
     * Display the change member username form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.changememberusername');
    }

    /**
     * Store new username for the member.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChangeMemberUsernameRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $member = Member::where('username', $request->old_username)->first();
            $member->username = $request->new_username;
            $member->save();
            
            DB::commit();
            return redirect()->route('admin.memberusername.index')->with('status-success', '['.$request->old_username . '] has been changed to [' . $request->new_username . ']');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }
}
