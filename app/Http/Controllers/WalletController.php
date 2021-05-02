<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EncashmentRequest;
use App\Models\TransactionEncashment;

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
            
            $data = $request->only('amount', 'req_type', 'name', 'mobile');
            $data['member_id'] = Auth::id();
            
            TransactionEncashment::create($data);
            
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
        
    }
}
