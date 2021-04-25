<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\Product;
use App\Library\Modules\MembersLibrary;
use App\Library\Modules\TransactionLibrary;
use App\Http\Requests\ActivationRequest;

class RefeshController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $member = Member::find(Auth::id());
        $products = Product::select(['id', 'name', 'price'])->get();
        
        return view('refresh-form', ['member' => $member, 'products' => $products]);
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
    public function store(ActivationRequest $request)
    {       
        try
        {
            DB::beginTransaction();
            
            $member = Member::find(Auth::id());
            
            switch ($request->payment_method)
            {
                case "ewallet":
                    $this->processActivation($member, $request);
                    break;
                
                case "paynamics":
                    throw new \Exception('Paynamics is currently unavailable');
                    break;
            }
            
            DB::commit();
            return redirect()->route('home', '#binary_status')->with('status-success', 'Your account has been activated');
            
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }
    
    private function processActivation(Member $member, $request)
    {
        $product = Product::find($request->product_id);

        if($member->total_amt < $product->price) {
            throw new \Exception('Your current balance is not enough to make transaction');
        }
                    
        MembersLibrary::updateMemberPlacementProduct($member, $product);
                    
        MembersLibrary::registerMemberPairingCycle($member);
        
        TransactionLibrary::saveProductPurchase($member, 'e_wallet');
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
