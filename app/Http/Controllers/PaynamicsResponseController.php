<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Common;
use App\Models\PaynamicsTransaction;

class PaynamicsResponseController extends Controller
{
    public function notification(Request $request)
    {
        
    }
    
    public function response(Request $request)
    {
        
    }
    
    public function cancel(Request $request)
    {
        try
        {
            $trans = PaynamicsTransaction::find($request->transaction_id);
            if($trans)
            {
                $responseid = base64_decode($request->responseid);
                $trans->response_id = $responseid;
                $trans->status = 'X';
                
                $remarks = [];
                if(!empty($trans->remarks)) {
                    $remarks = explode('|', $trans->remarks);
                }
                array_push($remarks, 'Cancelled by ' . $trans->member->username);
                $trans->remarks = implode("|", $remarks);
                $trans->save();
                
                return redirect()->route('codevault.purchaseform')
                        ->with('status-failed', 'You have cancelled a transaction');
            }
            
            return redirect()->route('codevault.purchaseform', '#payment_form')
                    ->with('status-failed', 'Unable to find Transaction ID#' . $request->transaction_id);
            
        } catch (\Exception $ex) {
            
            return redirect()->route('codevault.purchaseform', '#payment_form')
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }
}
