<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Library\DataTables;

class SwitchController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('switch');
    }
    
    public function data(Request $request)
    {
        $tablecols = [
            0 => 'created_at',
            1 => 'id',
            2 => 'username',
            3 => 'firstname|lastname',
            4 => 'total_amt'
        ];
        
        $ipAddress = Auth::user()->ip_address;
        
        $filteredmodel = DB::table('members')
                                ->where('ip_address', $ipAddress)
                                ->select(DB::raw("created_at,
                                                id,
                                                username,
                                                firstname,
                                                lastname,
                                                total_amt
                                                ")
                            );
        
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
    
    public function switchaccount($id)
    {
        Auth::loginUsingId($id);
        
        return redirect('home');
    }
}
