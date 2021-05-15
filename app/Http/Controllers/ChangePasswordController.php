<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\NewUserChangePasswordRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Member;

/**
 * @group Change Password for Members
 */
class ChangePasswordController extends Controller
{
    /**
     * Display change password form for new members
     * 
     * - Displayed to new members
     * - Forcing a member to change his/her default password
     */
    public function index(Request $request)
    {
        return view('auth.changepassword');
    }
    
    /**
     * Store password for New Members
     *
     * @bodyParam password string required
     * New password.
     *
     * @bodyParam password_confirmation string required
     * Confirmation for the new password.
     * 
     * @param  \App\Http\Requests\NewUserChangePasswordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewUserChangePasswordRequest $request)
    {
        $user = Member::find(Auth::id());
        $user->password = Hash::make($request->password);
        $user->must_change_password = 0;
        $user->password_changed_date = \Carbon\Carbon::now();
        $user->save();
        
        return redirect('home');
    }
    
    /**
     * Display change password form inside the system
     * 
     * - Link can be found on the left side menu under Settings
     */
    public function indexIn()
    {
        return view('changepassword');
    }
    
    /**
     * Store password for Existing Member
     * 
     * @bodyParam current_password string required
     * Current password.
     *
     * @bodyParam password string required
     * New password.
     *
     * @bodyParam confirm_password string required
     * Confirmation for the new password.
     * 
     * @param  \App\Http\Requests\ChangePasswordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeIn(ChangePasswordRequest $request)
    {
        $user = Member::find(Auth::id());
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect(route('changepassword.index'))
                ->with('status-success', 'Password has been changed');
    }
}
