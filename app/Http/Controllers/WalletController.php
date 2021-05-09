<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EncashmentRequest;
use App\Models\MembersEncashmentRequest;
use App\Library\DataTables;

class WalletController extends Controller
{
    const MINIMUM_REQUEST_AMOUNT = 500;
    
    public function index()
    {
        $member = Auth::user();
        
        return view('wallet-form', ['member' => $member, 'minimum_req' => self::MINIMUM_REQUEST_AMOUNT]);
    }
    
    public function postEncashment(EncashmentRequest $request)
    {
        try
        {
            DB::beginTransaction();
            
            $data = $request->only('source', 'amount', 'req_type', 'name', 'mobile');
            $data['member_id'] = Auth::id();
            
            MembersEncashmentRequest::create($data);
            
            DB::commit();
                    
            return redirect(route('wallet.history'))
                    ->with('status-success', 'Your encashment request has been submitted');
            
        } catch (\Exception $ex) {
            DB::rollback();
            
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }
    
    public function history()
    {
        $member = Auth::user();
        
        return view('wallet-history', ['member'=> $member]);
    }
    
    public function historydata(Request $request, $id)
    {        
        $tablecols = [
            0 => 'id',
            1 => 'created_at',
            2 => 'req_type',
            3 => 'amount',
            4 => 'name',
            5 => 'mobile',
            6 => 'tracking_no',
            7 => 'status',
        ];
        
        $filteredmodel = DB::table('members_encashment_requests')
                                ->where('member_id', $id)
                                ->select(DB::raw("amount, 
                                                req_type, 
                                                name,
                                                mobile,
                                                tracking_no,
                                                status,
                                                created_at,
                                                id")
                            );
        
        if($request->has('status') && !empty($request->status)) {
            $filteredmodel->where('status', $request->status);
        }
        
        if($request->has('start_date') && !empty($request->start_date)) {        
            if($request->has('end_date') && !empty($request->end_date && $request->start_date != $request->end_date)) {
                $filteredmodel->whereBetween('created_at', [$request->start_date, $request->end_date . ' 23:59:00']);
            } else {
                $filteredmodel->whereDate('created_at', $request->start_date);
            }
        }

        $modelcnt = $filteredmodel->count();

        $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }
}
