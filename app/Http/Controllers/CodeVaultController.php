<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class CodeVaultController extends Controller
{
    //
    public function index()
    {
        
    }
    
    public function purchaseform()
    {
        $member = Auth::user();
        $products = DB::table('products')->select('name', 'price', 'id')->get();
        
        return view('codevault-purchaseform', ['member' => $member, 'products' => $products]);
    }
    
    public function purchase(Request $request)
    {
        dd($request->all());
    }
}
