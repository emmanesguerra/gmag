<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\TransactionBonus;
use App\Library\DataTables;

class TransactionsController extends Controller
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
        
        $trans = Transaction::select(['id', 'firstname', 'lastname', 'email', 'product_code', 'product_price', 'transaction_date', 'package_claimed'])
                ->search($search)->orderBy('id', 'desc')
                ->paginate($show);
        
        return view('admin.transaction.index', ['trans' => $trans])->withQuery($search);
    }
    
    public function data(Request $request)
    {
        $tablecols = [
            0 => 'transaction_no',
            1 => 'firstname|lastname',
            2 => 'product_code',
            3 => 'product_price',
            4 => 'quantity',
            5 => 'total_amount',
            6 => 'transaction_date',
            7 => 'transaction_type',
            8 => 'payment_method|payment_source',
            9 => 'package_claimed'
        ];
        
        $filteredmodel = DB::table('transactions')
                                ->select(DB::raw("id, 
                                                transaction_no,
                                                firstname, 
                                                lastname,
                                                email,
                                                product_code,
                                                product_price,
                                                transaction_date,
                                                transaction_type,
                                                package_claimed,
                                                quantity,
                                                total_amount,
                                                payment_method,
                                                payment_source")
                            );
        
        if($request->has('start_date') && !empty($request->start_date)) {        
            if($request->has('end_date') && !empty($request->end_date && $request->start_date != $request->end_date)) {
                $filteredmodel->whereBetween('transaction_date', [$request->start_date, $request->end_date . ' 23:59:00']);
            } else {
                $filteredmodel->whereDate('transaction_date', $request->start_date);
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bonus(Request $request)
    {
        $search = $request->search;
        $show = (isset($request->show)) ? $request->show: 10;
        
        $trans = TransactionBonus::select(['id', 'member_id', 'class_id', 'type', 'acquired_amt'])
                ->with(['member' => function($query) {
                    $query->select('id', 'username', 'firstname', 'lastname');
                }])
                ->orderBy('id', 'desc')
                ->paginate($show);
        
        return view('admin.transaction.bonus', ['trans' => $trans])->withQuery($search);
    }
    
    public function bonusdata(Request $request)
    {
        $tablecols = [
            0 => 'a.created_at',
            1 => 'a.transaction_no',
            2 => 'b.username',
            3 => 'b.firstname|b.lastname',
            4 => 'a.field1|a.field2',
            5 => 'a.type',
            6 => 'a.acquired_amt'
        ];
        
        $filteredmodel = DB::table('transaction_bonuses as a')
                                ->join('members as b', 'b.id', '=', 'a.member_id')
                                ->select(DB::raw("a.id,  
                                                a.transaction_no,
                                                a.field1, 
                                                a.field2, 
                                                a.type,
                                                a.acquired_amt,
                                                a.created_at,
                                                b.username,
                                                b.firstname,
                                                b.lastname")
                            );
        
        if($request->has('status') && !empty($request->status)) {
            $filteredmodel->where('a.type', $request->status);
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
        //
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
}
