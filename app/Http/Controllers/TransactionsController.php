<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TransactionBonus;

class TransactionsController extends Controller
{
    //
    public function bonus(Request $request)
    {
        $search = $request->search;
        $show = (isset($request->show)) ? $request->show: 10;
        
        $trans = TransactionBonus::select(['id', 'member_id', 'class_id', 'type', 'acquired_amt', 'created_at'])
                ->with(['member' => function($query) {
                    $query->select('id', 'username', 'firstname', 'lastname');
                }])
                ->where('member_id', Auth::id())
                ->orderBy('id', 'desc')
                ->paginate($show);
        
        return view('transaction-bonus', ['trans' => $trans])->withQuery($search);
    }
}
