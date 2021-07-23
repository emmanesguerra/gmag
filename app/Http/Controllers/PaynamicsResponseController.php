<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Library\Common;
use App\Models\PaynamicsTransaction;
use App\Models\Member;
use App\Models\HonoraryMember;

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
                $trans->status = 'S';
                
                switch ($trans->transaction_type)
                {
                    case "Purchase":
                        Common::processProductPurchase($trans->member, $trans->product, $trans->quantity, $trans->transaction_type, $trans->payment_method, null, $trans->total_amount, $trans->transaction_no);
                        break;
                    case "Activation":
                        Common::processActivation($trans->member, $trans->product, $trans->quantity, $trans->transaction_type, $trans->payment_method, null, $trans->total_amount, $trans->transaction_no);
                        break;
                    case "Credit Adj":
                        $credit = HonoraryMember::find($trans->honorary_member_id);
                        if($credit->credit_amount > $trans->total_amount) {
                            $totalAmount = $trans->total_amount;
                            $diff = $credit->credit_amount - $trans->total_amount;
                        } else {
                            $totalAmount = $credit->credit_amount;
                            $diff = 0;
                        }

                        Common::processCreditAdj($trans->member, $credit, 'Credit Adj', $trans->payment_method, null, $totalAmount, $diff, $trans->transaction_no);
                        break;
                }
            } else if ($data && $this->transactionPending($data)) {
                $trans->status = 'WR';
            } else {
                $trans->status = 'F';
            }
            
            $remarks = [];
            if(!empty($trans->remarks)) {
                $remarks = explode('|', $trans->remarks);
            }
            array_push($remarks, date('Ymd H:i') . ' Pynmcs D: ' . $data['responseStatus']['response_message']);
            array_push($remarks, date('Ymd H:i') . ' Pynmcs D: ' . $data['responseStatus']['response_advise']);
            $trans->remarks = implode("|", $remarks);

            $trans->save();
            
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
    
    private function transactionPending($data)
    {
        if(isset($data['responseStatus']) && isset($data['responseStatus']['response_code'])) {
            if(in_array($data['responseStatus']['response_code'], ['GR033', 'GR033'])) {
                return true;
            }
        }
        
        return false;
    }
    
    public function response(Request $request)
    {
        $trans = PaynamicsTransaction::find($request->transaction_id);
        if($trans)
        {
            $responseid = base64_decode($request->responseid);
            $trans->response_id = $responseid;
            $trans->save();
            
            switch ($trans->transaction_type)
            {
                case "Purchase":
                    return view('paynamics-response', ['trans' => $trans]);
                    break;
                case "Activation":
                    return view('paynamics-response-1', ['trans' => $trans]);
                    break;
                case "Credit Adj":
                    return view('paynamics-response-2', ['trans' => $trans]);
                    break;
            }
                
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
