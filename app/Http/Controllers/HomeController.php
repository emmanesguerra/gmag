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
            'mspc' => $member->pairings()->ofType('MP')->count(),
            'fpc' => $member->pairings()->ofType('FP')->count(),
            'tspc' => $member->pairings()->whenDate(date('Y-m-d'))->count(),
            'yspc' => $member->pairings()->whenDate(date("Y-m-d", time() - 3600*24))->count()
        ];
        
        return view('home', ['member' => $member, 'counts' => $counts]);
    }
    
    public function earnings(Request $request)
    {
        $member = Member::find($request->member_id);
        
        if($request->start == date('Y-m-d') && $request->end == date('Y-m-d')) {
            
            return response()->json([
                'curr' => $member->total_amt,
                'dr' => $member->direct_referral,
                'eb' => $member->encoding_bonus,
                'mp' => $member->matching_pairs,
                'ewallet_purchased' => $member->purchased,
                'te' => $member->total_amt + $member->purchased,
                'fp' => $member->flush_pts,
                'success' => true
            ], 200);
        } else {
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
}
