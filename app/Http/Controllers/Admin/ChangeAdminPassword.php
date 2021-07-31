<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Http\Requests\ChangeAdminPasswordRequest;

/**
 * @group Admin/Admin Menu
 *
 */
class ChangeAdminPassword extends Controller
{
    /**
     * Display a change admin's password form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.changeadminpassword');
    }

    /**
     * Store new password for admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChangeAdminPasswordRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $admin = Admin::find(Auth::id());
            $admin->password = Hash::make($request->password);
            $admin->save();
            
            Auth::logout();
            
            DB::commit();
            return redirect('login/admin');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }
}
