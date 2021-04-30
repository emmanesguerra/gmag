<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\MemberLog;
use App\Models\MembersPairCycle;
use App\Library\DataTables;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $show = (isset($request->show)) ? $request->show: 10;
        
        $members = Member::select(['id', 'sponsor_id', 'username', 'firstname', 'lastname', 'matching_pairs', 'direct_referral', 'encoding_bonus', 'total_amt', 'flush_pts'])
                ->with(['sponsor' => function($query) {
                    $query->select('id', 'username');
                }])
                ->search($search)->orderBy('id', 'desc')
                ->paginate($show);
        
        return view('admin.members.index', ['members' => $members])->withQuery($search);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    
    public function visit(Request $request)
    {
        $search = $request->search;
        $show = (isset($request->show)) ? $request->show: 10;
        
        $members = MemberLog::select(['id', 'username', 'log_in', 'ip_address'])
                ->search($search)->orderBy('id', 'desc')
                ->paginate($show);
        
        return view('admin.members.visit', ['members' => $members])->withQuery($search);
    }
    
    public function cycle(Request $request, $id)
    {
        $tablecols = [
            0 => 'tb.created_at',
            1 => 'lft.username',
            2 => 'rgt.username',
            3 => 'tb.acquired_amt',
            4 => 'tb.type'
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
            1 => 'product_code',
            2 => 'product_price',
            3 => 'payment_method'
        ];
        
        $filteredmodel = DB::table('transactions')
                                ->where('member_id', $id)
                                ->select(DB::raw("transaction_date, 
                                                product_code, 
                                                product_price,
                                                payment_method")
                            );

        $modelcnt = $filteredmodel->count();

        $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }
}
