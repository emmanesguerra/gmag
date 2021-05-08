<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Library\Modules\TransactionLibrary;
use App\Library\Modules\EntryCodesLibrary;
use App\Library\Modules\PaynamicsLibrary;
use App\Http\Requests\CodePurchaseRequest;

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
    
    public function purchase(CodePurchaseRequest $request)
    {
        try
        {
            if($request->payment_method == 'ewallet' && $request->total_amount > $request->source_amount) {
                throw new \Exception("You don't have enough balance to purchase this request. Please choose other wallet source or use different payment method");
            }
            
            DB::beginTransaction();
            
            $paid = true;
            if($request->payment_method == 'paynamics') {
                $paid = PaynamicsLibrary::makeTransaction();
            }
            
            if(!$paid) {
                throw new \Exception("We recieved an error when processing your payment");
            } 
            
            $member = Auth::user();
            $product = Product::find($request->package);
            $trans = TransactionLibrary::saveProductPurchase($member, $product, $request->quantity, $request->payment_method, $request->source);

            if($trans) {
                EntryCodesLibrary::createEntryCodes($product, $member->id, $request->quantity, 'Purchased by ' . $member->username, $trans->id);
            }
            
            DB::commit();
            return redirect()->route('codevault.index')->with('status-success', 'Thank you for your purchase. Please use these entry codes below when registering new accounts');
            
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('codevault.purchaseform', '#payment_form')
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }
}
