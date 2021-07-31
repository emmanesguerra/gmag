<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\HonoraryMember;
use App\Library\Modules\TransactionLibrary;
use App\Library\Modules\MembersLibrary;
use App\Library\Modules\Paynamics\CashInLibrary;
use App\Library\Common;

/**
 * @group Members/Settlement
 *
 */
class HonoraryController extends Controller
{
    /**
     * Display settlement request form
     * 
     * @return Illuminate\View\View
     */
    public function settleform()
    {
        $member = Auth::user();
        $member->honorary;
        $walletTypes = DB::table('wallet_types')
                            ->whereNull('deleted_at')
                            ->select('method', 'name')
                            ->orderBy('sequence')->get();
        $paymentMethods = DB::table('payment_methods')
                            ->whereNull('deleted_at')
                            ->select('method', 'name')
                            ->orderBy('sequence')->get();
        $payinmethodsres = DB::table('paynamics_payin_methods')
                            ->whereNull('deleted_at')
                            ->select('method', 'type', 'type_name', 'description')
                            ->orderBy('type')->get();
        
        $payinmethods = [];
        foreach($payinmethodsres as $values) {
            $payinmethods[$values->type]['id'] = $values->type;
            $payinmethods[$values->type]['label'] = $values->type_name;
            $payinmethods[$values->type]['children'][] = [
                                            'id' => $values->method,
                                            'label' => $values->description
                                        ];
        }
        
        return view('settlement-form', ['member' => $member, 
            'walletTypes' => $walletTypes,
            'paymentMethods' => $paymentMethods,
            'payinmethods' => array_values($payinmethods)]);
    }
    
    

    /**
     * Process settlement request
     * 
     * @queryParam payment_method string required
     * Disbursement method. Example:paynamics or ewallet
     * 
     * @queryParam payinmethods array required
     * Payin method, this field is only required when payment_method is paynamics. Example: gcash, pnbotc
     * 
     * @queryParam total_amount string required
     * Total amount to pay, this field is editable when payment_method is paynamics. Example: 1000
     * 
     * @queryParam source string required
     * Wallet source, this field is only required when payment_method is ewallet. Example: direct_referral 
     * 
     * @queryParam source_amount string required
     * This field is auto populated. Example: 1000
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            if($request->payment_method == 'paynamics') {                
                $trans = TransactionLibrary::savePaynamicsTransaction($member, null, 'Credit Adj', 1, $request->total_amount, $request->honorary_id);
                
                $resp = CashInLibrary::processPayin($request, $trans);
                
                DB::commit();
                return view('refirect-to-paynamics', ['data' => $resp]);
                
            } else {
                $credit = HonoraryMember::find($request->honorary_id);
                if($credit->credit_amount > $request->source_amount) {
                    $totalAmount = $request->source_amount;
                    $diff = $credit->credit_amount - $request->source_amount;
                } else {
                    $totalAmount = $credit->credit_amount;
                    $diff = 0;
                }
                
                Common::processCreditAdj($member, $credit, 'Credit Adj', $request->payment_method, $request->source, $totalAmount, $diff);
                $route = 'settle.form';
                $ref = null;
                $msg = 'The transaction has been recorded';
            
                DB::commit();
                return redirect()->route($route, $ref)->with('status-success', $msg);
            }
            
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }
}
