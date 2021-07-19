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
            $requestID = date('YmdHis') . $trans->id;
            
            $this->checkWalletAmount($trans);
            
            $result = CashoutLibrary::processCashout($trans, $request, $request->tracking_no, $requestID);
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
        try
        {
            DB::beginTransaction();
        
            Log::channel('paynamics_noti')->info(date('Y-m-d H:i:s'));
            Log::channel('paynamics_noti')->info($request->all());

            $paymentResponse = $request->paymentresponse;
            $trans = MembersEncashmentRequest::find($request->transaction_id);

            $xmlString = base64_decode($paymentResponse);
            Log::channel('paynamics_noti')->info($xmlString);
            $data = Common::convertXmlToJson($xmlString);

            Log::channel('paynamics_noti')->info($data);

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
                Log::channel('paynamics_noti')->error($result);
                Log::channel('paynamics_noti')->error('Unable to translate paynamics response');
            }

            $xmlFile = CashoutLibrary::generateNotificationConfirmation($trans);

            DB::commit();
            header('Content-Type:text/xml');
            return $xmlFile;
            
        } catch (\Exception $ex) {
            DB::rollback();
            Log::channel('paynamics_noti')->error($ex->getMessage());
        }
    }
    
    public function paynamicsresp(Request $request)
    {
        Log::channel('paynamics_resp')->info($request->all());
        Log::channel('paynamics_resp')->info($request->getContent());
    }
    
    public function cancel($id)
    {
        try
        {
            DB::beginTransaction();
            $trans = MembersEncashmentRequest::find($id);

            if($trans) {
                if(in_array($trans->status, ['C', 'CX'])) {
                    $requestID = date('YmdHis') . $trans->id;
                    CashoutLibrary::cancelDisbursement($trans, $requestID);

                    if($trans->has_stashed_amount) {
                        MembersLibrary::returnStashedMemberRequestedAmount($trans);
                    }

                    $remarks = [];
                    if(!empty($trans->remarks)) {
                        $remarks = explode('|', $trans->remarks);
                    }
                    array_push($remarks, date('Ymd H:i') . ' ADMIN: ' . 'Cancelled by Admin');
                    $trans->remarks = implode("|", $remarks);
                    $trans->status = 'X';
                    $trans->save();

                    DB::commit();
                    return redirect(route('admin.encashment.index'))
                            ->with('status-success', 'The encashment request has been cancelled');
                }

                throw new \Exception('Transaction cannot be cancelled. Status should be either Confirmed or Confirmed with Issues');
            }

            throw new \Exception('Unable to retrieve encashment request.');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect(route('admin.encashment.index'))
                    ->with('status-failed', $ex->getMessage());
        }
    }
    
    public function retry(Request $request)
    {
        $id = $request->id;
        $trans = MembersEncashmentRequest::find($id);
        
        if($trans) {
            if(in_array($trans->status, ['CX'])) {
                $requestID = date('YmdHis') . $trans->id;
                CashoutLibrary::retryDisbursement($trans, $request, $requestID);
                
                $remarks = [];
                if(!empty($trans->remarks)) {
                    $remarks = explode('|', $trans->remarks);
                }
                array_push($remarks, date('Ymd H:i') . ' Admin: ' . 'Re-process by Admin');
                $trans->remarks = implode("|", $remarks);
                $trans->save();

                return redirect(route('admin.encashment.index'))
                        ->with('status-success', 'The encashment request has been re-processed ');
            }

            return redirect(route('admin.encashment.index'))
                    ->with('status-failed', 'Transaction is not retriable');
        }

        return redirect(route('admin.encashment.index'))
                ->with('status-failed', 'Unable to retrieve encashment request.');
    }
    
    public function query($id)
    {
        try
        {
            DB::beginTransaction();
            $trans = MembersEncashmentRequest::find($id);

            if($trans) {
                $requestID = date('YmdHis') . $trans->id;
                $result = CashoutLibrary::queryDisbursement($trans, $requestID);
                $data = Common::convertXmlToJson($result);

                if($data) {
                    if (!isset($data['queryDisbursmentDetailed_response'])) {
                        throw new \Exception('Unable to read paynamics response. Please try again later');
                    }
                    
                    if(CommonPynmcs::isQuerySuccessfulResp($data)) {
                        MembersLibrary::removeStashedMemberRequestedAmount($trans);
                        $trans->status = 'CC';
                    } else if (CommonPynmcs::isQuerySemiSuccessfulResp($data)) {
                        $trans->status = 'C';
                    } else if(CommonPynmcs::isQueryRetriableResp($data)) {
                        $trans->status = 'CX';
                    } else {
                        MembersLibrary::returnStashedMemberRequestedAmount($trans);
                        $trans->status = 'XX';
                    }
                    $remarks = [];
                    if(!empty($trans->remarks)) {
                        $remarks = explode('|', $trans->remarks);
                    }
                    if(!empty($request->remarks)) {
                        array_push($remarks, date('Ymd H:i') . ' Admin: ' . 'Status fetched by Admin');
                    }
                    array_push($remarks, CommonPynmcs::constructQueryRemarks($data));
                    $trans->remarks = implode("|", $remarks);
                    $trans->save();
                } else {
                    Log::channel('paynamics')->error($result);
                    throw new \Exception('Unable to translate paynamics response');
                }

                DB::commit();
                return redirect(route('admin.encashment.index'))
                        ->with('status-success', 'The encashment request status has been retrieved');
            }
            
            throw new \Exception('Unable to retrieve encashment request.');
            
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect(route('admin.encashment.index'))
                    ->with('status-failed', $ex->getMessage());

        }
    }
}
