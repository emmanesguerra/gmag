<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Library\Common;
use App\Models\PaynamicsTransaction;
use App\Models\Member;

class PaynamicsResponseController extends Controller
{
    public function notification(Request $request)
    {
        try
        {
            DB::beginTransaction();
        
            Log::channel('paynamics_noti')->info(date('Y-m-d H:i:s'));
            Log::channel('paynamics_noti')->info($request->all());

            $paymentResponse = $request->paymentresponse;
            $trans = PaynamicsTransaction::find($request->transaction_id);

            $paymentResponse2 = str_replace(" ", "+", $paymentResponse);
            $xmlString = base64_decode($paymentResponse2);
            Log::channel('paynamics_noti')->info($xmlString);
            $data = Common::convertXmlToJson($xmlString);
            Log::channel('paynamics_noti')->info($data);
            
            if($data && $this->transactionSuccessful($data))
            {
                switch ($trans->transaction_type)
                {
                    case "Purchased":
                        $this->processPurchased($trans);
                        break;
                    case "Activation":
                        $this->processActivation($trans);
                        break;
                    case "Credit Adj":
                        $this->processCreditAdj($trans);
                        break;
                }
            }
            
            DB::commit();
            
        } catch (\Exception $ex) {
            DB::rollback();
            Log::channel('paynamics_noti')->error($ex->getMessage());
        }
    }
    
    private function transactionSuccessful($data)
    {
        if(isset($data['responseStatus']) && isset($data['responseStatus']['response_code'])) {
            if(in_array($data['responseStatus']['response_code'], ['GR001', 'GR002'])) {
                return true;
            }
        }
        
        return false;
    }
    
    private function processPurchased(PaynamicsTransaction $trans)
    {
        Common::processProductPurchase($trans->member, $trans->product, $trans->quantity, $trans->transaction_type, $trans->payment_method, null, $trans->total_amount);
    }
    
    private function processActivation(PaynamicsTransaction $trans)
    {
        
    }
    
    private function processCreditAdj(PaynamicsTransaction $trans)
    {
        
    }
    
    public function response(Request $request)
    {
        $trans = PaynamicsTransaction::find($request->transaction_id);
        if($trans)
        {
            $responseid = base64_decode($request->responseid);
            $trans->response_id = $responseid;
            $trans->save();
            
            return view('paynamics-response', ['trans' => $trans]);
        }
        
        abort(404);
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
