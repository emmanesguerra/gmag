<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;

class SwitchController extends Controller
{
    //
    public function index(Request $request)
    {
        $ipAddress = Auth::user()->ip_address;
        
        $search = $request->search;
        $show = (isset($request->show)) ? $request->show: 10;
        
        $members = Member::select(['id', 'username', 'firstname', 'middlename', 'lastname', 'created_at', 'total_amt'])
                ->where('ip_address', $ipAddress)
                ->orderBy('id', 'desc')
                ->paginate($show);
        
        return view('switch', ['members' => $members])->withQuery($search);
    }
    
    public function switchaccount($id)
    {
        Auth::loginUsingId($id);
        
        return redirect('home');
    }
}
