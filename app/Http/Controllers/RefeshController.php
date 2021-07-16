<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\Product;
use App\Library\Modules\MembersLibrary;
use App\Library\Modules\TransactionLibrary;
use App\Library\Modules\Paynamics\CashInLibrary;
use App\Http\Requests\ActivationRequest;

/**
 * @group Members/Dashboard
 *
 */
class RefeshController extends Controller
{
    /**
     * Display the re-activation form of the pairing cycle.
     * 
     * - Once pairing cycle is reactivated, registration of Match Pairs and Flush Pairs continues.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $member = Member::find(Auth::id());
        $member->placement->product;
        $products = Product::select(['id', 'name', 'price'])->get();
        $walletTypes = DB::table('wallet_types')
                            ->whereNull('deleted_at')
                            ->select('method', 'name')
                            ->orderBy('sequence')->get();
        $paymentMethods = DB::table('payment_methods')
                            ->whereNull('deleted_at')
                            ->select('method', 'name')
                            ->orderBy('sequence')->get();
        $payinmethodsres = DB::table('paynamics_payin_methods')
                            ->whereNull('deleted_at')
                            ->select('method', 'type', 'type_name', 'description')
                            ->orderBy('type')->get();
        
        $payinmethods = [];
        foreach($payinmethodsres as $values) {
            $payinmethods[$values->type]['id'] = $values->type;
            $payinmethods[$values->type]['label'] = $values->type_name;
            $payinmethods[$values->type]['children'][] = [
                                            'id' => $values->method,
                                            'label' => $values->description
                                        ];
        }
        
        return view('refresh-form', ['member' => $member, 'products' => $products,
            'walletTypes' => $walletTypes,
            'paymentMethods' => $paymentMethods,
            'payinmethods' => array_values($payinmethods)]);
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
     * Process activation of the pairing cycle of a member
     *
     * @queryParam product_id integer required
     * Product id
     *
     * @queryParam total_amount float required
     * Product price * Quantity. Example: 1999.99
     *
     * @queryParam payment_method string required
     * Either E-wallet or Paynamics. Example: ewallet,paynamics
     *
     * @queryParam source string required
     * Required if payment_method = E-wallet
     *
     * @queryParam source_amount float required
     * Current wallet amount. Example: 1999.99
     * 
     * @param  \App\Http\Requests\ActivationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivationRequest $request)
    {       
        try
        {
            if($request->payment_method == 'ewallet' && $request->total_amount > $request->source_amount) {
                throw new \Exception("You don't have enough balance to purchase this request. Please choose other wallet source or use different payment method");
            }
            
            DB::beginTransaction();
            
            $member = Auth::user();
            $product = Product::find($request->product);
            if($request->payment_method == 'paynamics') {                
                $trans = TransactionLibrary::savePaynamicsTransaction($member, $product, 'Activation', $request->quantity, $request->total_amount);
                
                $resp = CashInLibrary::processPayin($request, $trans);
                
                DB::commit();
                return view('refirect-to-paynamics', ['data' => $resp]);
                
            } else {
                Common::processActivation($member, $product, $request->quantity, 'Activation', $request->payment_method, $request->source, $trans->total_amount);

                DB::commit();
                return redirect()->route('home', '#binary_status')->with('status-success', 'Your account has been activated');
            }
            
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
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
