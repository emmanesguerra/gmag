<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Library\DataTables;
use App\Models\MembersEncashmentRequest;
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
            3 => 'a.req_type',
            4 => 'a.name',
            5 => 'a.mobile',
            6 => 'a.amount',
            7 => 'a.amount',
            8 => 'a.tracking_no',
            9 => 'a.status',
        ];
        
        $filteredmodel = DB::table('members_encashment_requests as a')
                                ->join('members as b', 'b.id', '=', 'a.member_id')
                                ->select(DB::raw("a.id, 
                                                a.created_at,
                                                b.username,
                                                a.req_type, 
                                                a.name,
                                                a.mobile,
                                                CASE 
                                                    WHEN a.source = 'direct_referral' THEN b.direct_referral
                                                    WHEN a.source = 'encoding_bonus' THEN b.encoding_bonus
                                                    ELSE b.matching_pairs
                                                END as source_amount,
                                                a.amount,
                                                a.tracking_no,
                                                a.status")
                            );

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
            $trans->tracking_no = $request->tracking_no;
            $trans->remarks = $request->remarks;
            $trans->status = 'C';
            $trans->save();
            
            DB::commit();
            return response(['success' => true], 200);
            
        } catch (\Exception $ex) {
            DB::rollback();
            return response(['success' => false,
                'message' => $ex->getMessage()], 400);
        }
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
}
