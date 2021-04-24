<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $member = Member::find(Auth::id());
        
        $counts = [
            'tpc' => $member->pairings->count(),
            'mspc' => $member->pairingsMP->count(),
            'fpc' => $member->pairingsFP->count(),
            'tspc' => $member->pairingsToday->count(),
            'yspc' => $member->pairingsYesterday->count()
        ];
        
        return view('home', ['member' => $member, 'counts' => $counts]);
    }
}
