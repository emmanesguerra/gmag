<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\MemberLog;
use App\Models\MembersPairCycle;
use App\Library\DataTables;
use App\Http\Requests\ProfileUpdateRequest;

/**
 * @group Admin/Members Menu
 *
 */
class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.members.index');
    }
    
    public function data(Request $request)
    {
        $tablecols = [
            0 => 'a.created_at',
            1 => 'a.username',
            2 => 'a.firstname|a.lastname',
            3 => 'b.username',
            4 => 'a.matching_pairs',
            5 => 'a.direct_referral',
            6 => 'a.encoding_bonus',
            7 => 'a.total_amt',
            8 => 'a.flush_pts',
        ];
        
        $filteredmodel = DB::table('members as a')
                                ->leftjoin('members as b', 'b.id', '=', 'a.sponsor_id')
                                ->select(DB::raw("a.id, 
                                                a.username, 
                                                a.firstname,
                                                a.lastname,
                                                a.matching_pairs,
                                                a.direct_referral,
                                                a.encoding_bonus,
                                                a.total_amt,
                                                a.flush_pts,
                                                a.created_at,
                                                b.username as sponsor")
                            );
        
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = Member::find($id);
        
        return view('admin.members.show', ['member' => $member]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = Member::find($id);
        
        return view('admin.members.edit', ['member' => $member]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileUpdateRequest $request, $id)
    {
        try
        {            
            DB::beginTransaction();
            
            $member = Member::find($id);           
            $member->update($request->only([
                'birthdate', 
                'email', 
                'mobile', 
                'address']));
            
            DB::commit();
            
            return redirect()->route('admin.member.edit', $id)->with('status-success', 'Your profile has been updated');
            
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function visit()
    {
        return view('admin.members.visit');
    }
    
    public function visitdata(Request $request)
    {
        $tablecols = [
            0 => 'a.id',
            1 => 'a.log_in',
            2 => 'a.ip_address',
            3 => 'b.username',
        ];
        
        $filteredmodel = DB::table('member_logs as a')
                                ->join('members as b', 'b.id', '=', 'a.member_id')
                                ->select(DB::raw("a.id, 
                                                b.username, 
                                                a.log_in,
                                                a.ip_address")
                            );
        
        if($request->has('start_date') && !empty($request->start_date)) {        
            if($request->has('end_date') && !empty($request->end_date && $request->start_date != $request->end_date)) {
                $filteredmodel->whereBetween('log_in', [$request->start_date, $request->end_date . ' 23:59:00']);
            } else {
                $filteredmodel->whereDate('log_in', $request->start_date);
            }
        }

        $modelcnt = $filteredmodel->count();

        $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }
    
    public function cycle(Request $request, $id)
    {
        $tablecols = [
            0 => 'tb.created_at',
            1 => 'tb.transaction_no',
            2 => 'lft.username',
            3 => 'rgt.username',
            4 => 'tb.acquired_amt',
            5 => 'tb.type'
        ];
        
        $cycle = Member::find($id)->latest_pair_cycle;
        $cycleId = $cycle->id;
        if($request->has('cycle_id')) {
            $cycleId = $request->cycle_id;
        }
        
        $cycle = MembersPairCycle::select('starting_pair_id', 'ending_pair_id')->where('id', $cycleId)->first();
        
        if(!empty($cycle->starting_pair_id)) {
            $filteredmodel = DB::table('transaction_bonuses as tb')
                                    ->join('members_pairings as mp', 'mp.id', '=', 'tb.class_id')
                                    ->join('members as lft', 'lft.id', '=', 'mp.lft_mid')
                                    ->join('members as rgt', 'rgt.id', '=', 'mp.rgt_mid')
                                    ->join('products as prod', 'prod.id', '=', 'mp.product_id')
                                    ->where('tb.member_id', $id)
                                    ->whereIn('tb.type', ['MP', 'FP']);
            if($cycle->ending_pair_id) {
                $filteredmodel->whereBetween('tb.class_id', [$cycle->starting_pair_id, $cycle->ending_pair_id]);
            } else if ($cycle->starting_pair_id) {
                $filteredmodel->where('tb.class_id', '>=', $cycle->starting_pair_id);
            }
            $filteredmodel->select(DB::raw("tb.created_at, 
                                        tb.transaction_no,
                                        lft.username as lusername, 
                                        rgt.username as rusername,
                                        tb.type,
                                        tb.acquired_amt")
                                );

            $modelcnt = $filteredmodel->count();

            $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

            return response(['data'=> $data,
                'draw' => $request->draw,
                'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
                'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
        }

        return response(['data'=> [],
            'draw' => $request->draw,
            'recordsTotal' => 0,
            'recordsFiltered' => 0], 200);
    }
    
    public function purchased(Request $request, $id)
    {
        $tablecols = [
            0 => 'transaction_date',
            1 => 'transaction_no',
            2 => 'transaction_type',
            3 => 'product_code',
            4 => 'product_price',
            5 => 'payment_method'
        ];
        
        $filteredmodel = DB::table('transactions')
                                ->where('member_id', $id)
                                ->select(DB::raw("transaction_date,  
                                                transaction_no, 
                                                transaction_type, 
                                                product_code, 
                                                product_price,
                                                payment_method,
                                                payment_source")
                            );

        $modelcnt = $filteredmodel->count();

        $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }
    
    /**
     * Display the list of purchased transactions of the member
     *
     * @queryParam request array required 
     * JSON request generated by DataTable
     * 
     * @queryParam id integer required
     * Member's ID
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function credits(Request $request, $id)
    {
        $tablecols = [
            0 => 'a.created_at',
            1 => 'b.transaction_no',
            2 => 'a.credit_amount',
            3 => 'a.amount_paid',
            4 => 'a.status'
        ];
        
        $filteredmodel = DB::table('honorary_members as a')
                                ->join('transactions as b', 'b.id', '=', 'a.transaction_id')
                                ->where('a.member_id', $id)
                                ->select(DB::raw("a.credit_amount,  
                                                b.transaction_no, 
                                                a.amount_paid, 
                                                a.status,
                                                a.created_at")
                            );

        $modelcnt = $filteredmodel->count();

        $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }
}
