<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\NewUserChangePasswordRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Member;

class ChangePasswordController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('auth.changepassword');
    }
    
    public function store(NewUserChangePasswordRequest $request)
    {
        $user = Member::find(Auth::id());
        $user->password = Hash::make($request->password);
        $user->must_change_password = 0;
        $user->password_changed_date = \Carbon\Carbon::now();
        $user->save();
        
        return redirect('home');
    }
    
    public function indexIn()
    {
        return view('changepassword');
    }
    
    public function storeIn(ChangePasswordRequest $request)
    {
        $user = Member::find(Auth::id());
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect(route('changepassword.index'))
                ->with('status-success', 'Password has been changed');
    }
}
