<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;

/**
 * @group Member's Dashboard
 *
 */
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
     * Display member's application dashboard
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $member = Member::find(Auth::id());
        
        $counts = [
            'tpc' => $member->pairings->count(),
            'mspc' => $member->pairings()->ofType('MP')->count(),
            'fpc' => $member->pairings()->ofType('FP')->count(),
            'tspc' => $member->pairings()->whenDate(date('Y-m-d'))->count(),
            'yspc' => $member->pairings()->whenDate(date("Y-m-d", time() - 3600*24))->count()
        ];
        
        return view('home', ['member' => $member, 'counts' => $counts]);
    }
    

    /**
     * Updates the dashboard earnings depends on the selected date range.
     *
     * @queryParam start date required
     * Starting date. Example: 2021-05-01
     *
     * @queryParam end date required
     * Ending date. Example: 2021-05-30
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function earnings(Request $request)
    {
        $member = Member::find($request->member_id);
        
        $range = [
              $request->start." 00:00:00", $request->end." 23:59:59"  
        ];

        $ewallet = $member->transactions()->ofPaymentMethod('e_wallet')->whereBetween('transaction_date', $range)->sum('product_price');
        $total_earnings = $member->transactionBonuses()->ofNotType('FP')->whereBetween('created_at', $range)->sum('acquired_amt');

        return response()->json([
            'curr' => $total_earnings - $ewallet,
            'dr' => $member->transactionBonuses()->ofType('DR')->whereBetween('created_at', $range)->sum('acquired_amt'),
            'eb' => $member->transactionBonuses()->ofType('EB')->whereBetween('created_at', $range)->sum('acquired_amt'),
            'mp' => $member->transactionBonuses()->ofType('MP')->whereBetween('created_at', $range)->sum('acquired_amt'),
            'ewallet_purchased' => $ewallet,
            'te' => $total_earnings,
            'fp' => $member->transactionBonuses()->ofType('FP')->whereBetween('created_at', $range)->sum('acquired_amt'),
            'success' => true
        ], 200);
    }
}
