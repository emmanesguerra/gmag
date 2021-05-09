<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionBonus;
use App\Library\DataTables;

class TransactionsController extends Controller
{
    //
    public function bonus(Request $request)
    {
        $memberId = Auth::id();
        
        return view('transaction-bonus', ['memberId' => $memberId]);
    }
    
    public function bonusdata(Request $request, $id)
    {
        $tablecols = [
            0 => 'created_at',
            1 => 'field1|field2',
            2 => 'type',
            3 => 'acquired_amt'
        ];
        
        $filteredmodel = DB::table('transaction_bonuses')
                                ->where('member_id', $id)
                                ->select(DB::raw("id,  
                                                field1, 
                                                field2, 
                                                type,
                                                acquired_amt,
                                                created_at")
                            );

        $modelcnt = $filteredmodel->count();

        $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }
}
