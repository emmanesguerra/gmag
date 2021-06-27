<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Library\DataTables;
use App\Library\Common;
use App\Library\Modules\Paynamics\CashoutLibrary;
use App\Library\Modules\Paynamics\CommonPynmcs;
use App\Library\Modules\MembersLibrary;
use App\Models\MembersEncashmentRequest;
use App\Models\TransactionEncashment;
use App\Models\PaynamicsEncashmentResp;
use App\Http\Requests\ApproveEncashmentRequest;

class EncashmentController extends Controller
{
    //
    public function index()
    {
        return view('admin.encashment.index');
    }
    
    public function data(Request $request)
    {
        $tablecols = [
            0 => 'a.id',
            1 => 'a.created_at',
            2 => 'b.username',
            3 => 'a.disbursement_method',
            4 => 'a.amount',
            5 => 'a.tracking_no',
            6 => 'a.status',
        ];
        
        $filteredmodel = DB::table('members_encashment_requests as a')
                                ->join('members as b', 'b.id', '=', 'a.member_id')
                                ->select(DB::raw("a.id, 
                                                a.created_at,
                                                b.username,
                                                a.disbursement_method, 
                                                a.amount,
                                                a.tracking_no,
                                                a.status")
                            );
        
        if($request->has('status') && !empty($request->status)) {
            $filteredmodel->where('a.status', $request->status);
        }
        
        if($request->has('start_date') && !empty($request->start_date)) {        
            if($request->has('end_date') && !empty($request->end_date && $request->start_date != $request->end_date)) {
                $filteredmodel->whereBetween('a.created_at', [$request->start_date, $request->end_date . ' 23:59:00']);
            } else {
                $filteredmodel->whereDate('a.created_at', $request->start_date);
            }
        }

        $modelcnt = $filteredmodel->count();

        $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }
    
    public function approve(ApproveEncashmentRequest $request)
    {
        try 
        {
            DB::beginTransaction();
            
            $trans = MembersEncashmentRequest::find($request->id);
            $requestID = 'GM' . date('ynjHis') . $trans->id;
            
            $this->checkWalletAmount($trans);
            
            $result = CashoutLibrary::processCashout($trans, $request->tracking_no, $requestID);
            $data = Common::convertXmlToJson($result);
            
            if($data) {
                if(CommonPynmcs::isSuccessfulResp($data)) {
                    // move the requested amount to X
                    MembersLibrary::stashMemberRequestedAmount($trans);
                    
                    PaynamicsEncashmentResp::create([
                        'encashment_id' => $trans->id, 
                        'request_id' => $data['header_response']['request_id'], 
                        'hed_response_id' => $data['header_response']['response_id'], 
                        'hed_response_code' => $data['header_response']['response_code'], 
                        'hed_response_message' => $data['header_response']['response_message'],
                        'det_response_id' => $data['details_response']['details_response']['response_id'] , 
                        'det_response_code' => $data['details_response']['details_response']['response_code'] , 
                        'det_response_message' => $data['details_response']['details_response']['response_message'], 
                        'det_processor_response_id' => implode(',' , $data['details_response']['details_response']['processor_response_id'])
                    ]);
                    
                    $trans->status = 'C';
                } else if(CommonPynmcs::isRetriableResp($data)) {
                    $trans->status = 'CX';
                } else {
                    $trans->status = 'XX';
                }
                $remarks = [];
                if(!empty($trans->remarks)) {
                    $remarks = explode('|', $trans->remarks);
                }
                if(!empty($request->remarks)) {
                    array_push($remarks, date('Ymd H:i') . ' ADMIN: ' . $request->remarks);
                }
                array_push($remarks, CommonPynmcs::constructRemarks($data));
                $trans->remarks = implode("|", $remarks);
                $trans->tracking_no = $request->tracking_no;
                $trans->generated_req_id = $requestID;
                $trans->save();
            } else {
                Log::channel('paynamics')->error($result);
                throw new \Exception('Unable to translate paynamics response');
            }
            
            DB::commit();
            return response(['success' => true], 200);
            
        } catch (\Exception $ex) {
            DB::rollback();
            return response(['success' => false,
                'message' => $ex->getMessage()], 400);
        }
    }
    
    private function checkWalletAmount(MembersEncashmentRequest $trans)
    {
        $member = $trans->member;
        $source = $trans->source;
        $previousAmount = $member->$source;
        $deductedAmount = $trans->amount;
        $newAmount = $previousAmount - $deductedAmount;

        if($newAmount < 0) {
            throw new \Exception('Not enough wallet amount');
        }
        
        return;
    }
    
    public function reject(Request $request)
    {
        try 
        {
            DB::beginTransaction();
            
            if(!$request->has('id') || empty($request->id)) {
                throw new \Exception('Something is missing in your request. Please refresh the page.');
            }
            
            $trans = MembersEncashmentRequest::find($request->id);
            
            if($trans->has_stashed_amount) {
                MembersLibrary::returnStashedMemberRequestedAmount($trans);
            }
            
            $remarks = [];
            if(!empty($trans->remarks)) {
                $remarks = explode('|', $trans->remarks);
            }
            if(!empty($request->remarks)) {
                array_push($remarks, date('Ymd H:i') . ' ADMIN: ' . $request->remarks);
            }
            $trans->remarks = implode("|", $remarks);
                
            $trans->status = 'X';
            $trans->save();
            
            DB::commit();
            return response(['success' => true], 200);
            
        } catch (\Exception $ex) {
            DB::rollback();
            return response(['success' => false,
                'message' => $ex->getMessage()], 400);
        }
    }
    
    public function paynamicsnoti(Request $request)
    {
        Log::channel('paynamics_noti')->info(date('Y-m-d H:i:s'));
        Log::channel('paynamics_noti')->info($request->all());
        
        $paymentResponse = 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48UmVzcG9uc2UgeG1sbnM6eHNkPSJodHRwOi8vd3d3LnczLm9yZy8yMDAxL1hNTFNjaGVtYSIgeG1sbnM6eHNpPSJodHRwOi8vd3d3LnczLm9yZy8yMDAxL1hNTFNjaGVtYS1pbnN0YW5jZSI+PGhlYWRlcl9yZXNwb25zZT48bWVyY2hhbnRpZD4wMDAwMDAwMDAwMDAwMDI8L21lcmNoYW50aWQ+PHJlcXVlc3RfaWQ+UEFZTkFNSUNTX1RFU1RfMjY0NTwvcmVxdWVzdF9pZD48cmVzcG9uc2VfaWQ+SEVEUl8yNDk3MDYyMjE3NTMwMDY8L3Jlc3BvbnNlX2lkPjxyZXNwb25zZV9jb2RlPkdSMDAzPC9yZXNwb25zZV9jb2RlPjxyZXNwb25zZV9tZXNzYWdlPlRyYW5zYWN0aW9uIEZhaWxlZC48L3Jlc3BvbnNlX21lc3NhZ2U+PHNpZ25hdHVyZT41NmZlM2NkOGUyZDQyYTY1ZDY3NmIwNjYzYzkzYjMxYjQzNTMzNWIxMzJmNGI3MTYzYzQ1OTY5OGI2ZGZkMjRkYjFlYTZlMDJhZWU1YTc0YzNmOGZmNTdjOTZiYzE0ZWFmNmYyNDgwYmMzZmQzNzQ4NjBmMjQ2OTkxOTBkYjc5MDwvc2lnbmF0dXJlPjx0aW1lc3RhbXA+MjAyMS0wNi0yNVQxMToyMDozMy43MDEwMDAwKzA4OjAwPC90aW1lc3RhbXA+PC9oZWFkZXJfcmVzcG9uc2U+PGRldGFpbHNfcmVzcG9uc2U+PGRldGFpbHNfcmVzcG9uc2U+PG1lcmNoYW50aWQ+MDAwMDAwMDAwMDAwMDAyPC9tZXJjaGFudGlkPjxyZXF1ZXN0X2lkPlBBWU5BTUlDU19URVNUXzI2NDU8L3JlcXVlc3RfaWQ+PHJlc3BvbnNlX2lkPkRFVFJfNTg1MDM4NjEyMzk0MTQ2PC9yZXNwb25zZV9pZD48dGltZXN0YW1wPjIwMjEtMDYtMjVUMTE6MTk6NTAuMTA3MDAwMCswODowMDwvdGltZXN0YW1wPjxyZXNwb25zZV9jb2RlPkdSMDI4PC9yZXNwb25zZV9jb2RlPjxyZXNwb25zZV9tZXNzYWdlPlRyYW5zYWN0aW9uIEZhaWxlZCBkdWUgdG8gSW52YWxpZCBUcmFuc2ZlcmVlIEFjY291bnQuPC9yZXNwb25zZV9tZXNzYWdlPjxwcm9jZXNzb3JfcmVzcG9uc2VfaWQgLz48c2lnbmF0dXJlPjFkOGMzZTM1NWMyYjIxNTEyNzEwMGFjMTE3YTRhNTI1ZWY1MWMzNTA3YWM1MTVhNjg2NmVhMzE5NDg0Mjc3MjA2ZDhhZTAyN2U0Y2IyNTExZDA1NjIxNGY5NTVjMGNkNjc5NzA1YzAxZTlhZjM4ZGI1ZWRhYzczZDBiNmFmNzlhPC9zaWduYXR1cmU+PC9kZXRhaWxzX3Jlc3BvbnNlPjwvZGV0YWlsc19yZXNwb25zZT48L1Jlc3BvbnNlPg==';
        $trans = MembersEncashmentRequest::find($request->transaction_id);

        $xmlString = base64_decode($paymentResponse);
        $data = Common::convertXmlToJson($xmlString);

        if($data) {
            if(CommonPynmcs::isSuccessfulResp($data)) {
                // move the requested amount to X
                if($trans->has_stashed_amount) {
                    MembersLibrary::removeStashedMemberRequestedAmount($trans);
                }

                $trans->status = 'CC';
            } else if(CommonPynmcs::isRetriableResp($data)) {
                $trans->status = 'CX';
            } else {
                if($trans->has_stashed_amount) {
                    MembersLibrary::returnStashedMemberRequestedAmount($trans);
                }
                $trans->status = 'XX';
            }
            $remarks = [];
            if(!empty($trans->remarks)) {
                $remarks = explode('|', $trans->remarks);
            }
            array_push($remarks, CommonPynmcs::constructRemarks($data));
            $trans->remarks = implode("|", $remarks);
            $trans->save();
        } else {
            Log::channel('paynamics')->error($result);
            Log::channel('paynamics')->error('Unable to translate paynamics response');
        }
        
        $xmlFile = CashoutLibrary::generateNotificationConfirmation($trans);
        
        header('Content-Type:text/xml');
        return $xmlFile;
    }
    
    public function paynamicsresp(Request $request)
    {
        Log::channel('paynamics_resp')->info($request->all());
        Log::channel('paynamics_resp')->info($request->getContent());
    }
}
