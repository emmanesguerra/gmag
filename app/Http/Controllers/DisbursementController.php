<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class DisbursementController extends Controller
{
    public function index(Request $request)
    {
        $member = Member::find($request->member);
        $method = $request->method;
        
        return view('disbursement-detail-form', ['member' => $member, 'method' => $method]);
    }
}
