<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\HonoraryMember;
use App\Library\Modules\TransactionLibrary;
use App\Library\Modules\MembersLibrary;

class HonoraryController extends Controller
{
    public function settleform()
    {
        $member = Auth::user();
        
        return view('settlement-form', ['member' => $member]);
    }
    
    public function settleamount(Request $request)
    {
        try
        {
            DB::beginTransaction();
            
            if(empty($request->payment_method)) {
                throw new \Exception('Payment method is required');
            }
            
            if($request->payment_method == 'ewallet' && empty($request->source_amount)) {
                throw new \Exception('Source amount cannot be empty');
            }
            
            $member = Auth::user();
            $credit = HonoraryMember::find($request->honorary_id);
            if($request->payment_method == 'ewallet') {
                if($credit->credit_amount > $request->source_amount) {
                    $totalAmount = $request->source_amount;
                    $diff = $credit->credit_amount - $request->source_amount;
                } else {
                    $totalAmount = $credit->credit_amount;
                }
            } else {
                $totalAmount = $credit->credit_amount;
            }
            
            $trans = TransactionLibrary::saveProductPurchase($member, null, 0, 'Credit Adj', $request->payment_method, $request->source, $totalAmount);
            
            if($trans) {
                $credit->transaction_id = $trans->id;
                $credit->amount_paid = $totalAmount;
                $credit->status = 'Paid';
                $credit->save();
                
                if(isset($diff) && $diff > 0) {
                    MembersLibrary::createHonoraryRecord($member, $diff);
                } else {
                    $member->has_credits = 0;
                    $member->save();
                }
            }
            
            DB::commit();
            return redirect()->route('settle.form')->with('status-success', 'The transaction has been recorded');
            
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }
}
