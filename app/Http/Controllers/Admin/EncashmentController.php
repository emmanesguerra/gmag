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
            
            $this->checkWalletAmount($trans);
            
            $result = CashoutLibrary::processCashout($trans, $request->tracking_no);
            $data = Common::convertXmlToJson($result);
            
            if($data) {
                if(CommonPynmcs::isSuccessfulResp($data)) {
                    // move the requested amount to X
                    MembersLibrary::stashMemberRequestedAmount($trans);
                    $trans->status = 'C';
                } else {
                    $trans->status = 'CX';
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
            $trans->remarks = $request->remarks;
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
        Log::channel('paynamics_noti')->info($request->getContent());

        echo 'accesible' . date('Y-m-d H:i:s');
    }
    
    public function paynamicsresp(Request $request)
    {
        Log::channel('paynamics_resp')->info($request->all());
        Log::channel('paynamics_resp')->info($request->getContent());
    }
}
