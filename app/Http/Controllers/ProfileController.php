<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Member;
use App\Models\MemberDocument;
use App\Models\PaynamicsTransaction;
use App\Models\MembersPairCycle;
use App\Models\HonoraryMember;
use App\Library\DataTables;
use App\Library\Modules\Paynamics\CashInLibrary;
use App\Library\Common;
use App\Http\Requests\ProfileUpdateRequest;

/**
 * @group Members/Dashboard
 *
 */   
class ProfileController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Display profile page
     *
     * @queryParam id integer required
     * Member's ID
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = Member::find($id);
        
        return view('profile-show', ['member' => $member]);
    }

    /**
     * Display profile edit form page
     *
     * @queryParam id integer required
     * Member's ID
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = Member::find($id);
        
        $pdocumentTypes = DB::table('document_options')->whereNull('deleted_at')->where('is_primary', 1)->get();
        $sdocumentTypes = DB::table('document_options')->whereNull('deleted_at')->where('is_primary', 0)->get();
        
        return view('profile-edit', ['member' => $member, 
            'pdocumentTypes' => $pdocumentTypes, 
            'sdocumentTypes' => $sdocumentTypes]);
    }

    /**
     * Process updating of profile
     * 
     * @pathParam  id integer required
     * Member's ID
     *
     * @queryParam birthdate date required
     * Member's birthdate. Example: 1989-08-25
     *
     * @queryParam email email required
     * Member's email address. Example: your-email@example.com
     *
     * @queryParam mobile numeric required
     * Member's contact info. Example: 09091234567
     *
     * @queryParam address text required
     * Member's address. Example: "Don Geronimo St."
     * 
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileUpdateRequest $request, $id)
    {        
        try
        {   
            $validate = $this->validateFileUploads($request);
            if(!empty($validate)) {
                throw new \Exception(implode('<br />', $validate));
            }
            
            DB::beginTransaction();
            
            $member = Member::find($id);           
            $member->update($request->only(['firstname', 'middlename', 'lastname', 
                                'birthdate', 'email', 'mobile', 'address1', 'address2', 
                                'address3', 'city', 'state', 'country', 'zip', 
//                                'nationality', 'nature_of_work'
                ]));
            
//            foreach($request->document as $key => $docs) {
//                if(!empty($docs['doc'])) {
//                    $fileName = (isset($docs['proof']) ? $docs['proof']: null);
//                    if($request->hasFile('doc_proof_' . $key)) {
//                        $proof = $request->file('doc_proof_' . $key);
//                        $fileName = 'D'.$key.'-U' . strtoupper(substr($member->username,0,7)) .'-I' . $member->id . '.' . $proof->getClientOriginalExtension();
//                        Storage::disk('document_proof')->put($member->id . '/'. $fileName, file_get_contents($proof));
//                    }
//
//                    MemberDocument::updateOrCreate(['member_id' => $member->id, 
//                                                    'type' => $key + 1], 
//                                                   ['doc_type' => $docs['doc'],
//                                                    'doc_id' => $docs['idnum'],
//                                                    'expiry_date' => $docs['exp'],
//                                                    'proof' => $fileName ]);
//                }
//            }
            
            DB::commit();
            
            return redirect()->route('profile.edit', $id)->with('status-success', 'Your profile has been updated');
            
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }
    
    private function validateFileUploads($request)
    {        
        $response = [];
        $errors = [];
        
//        foreach($request->document as $key => $docs) {
//            if(!empty($docs['doc'])) {
//                if(!$request->hasFile('doc_proof_' . $key) && !isset($docs['proof'])) {
//                    $errors[] = 'Document Proof on box '.($key + 1).' is required';
//                }
//            }
//        }
//        
//        if(!empty($errors)) {
//            $response = [
//                "There's something wrong with your request:",
//                ""
//            ];
//            foreach($errors as $err) {
//                array_push($response, $err);
//            }
//        }
        
        return $response;
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
    
    /**
     * Display the list of paired members on a specific cycle
     *
     * @queryParam request array required 
     * JSON request generated by DataTable
     * 
     * @queryParam id integer required
     * Member's ID
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cycle(Request $request, $id)
    {
        $tablecols = [
            0 => 'tb.created_at',
            1 => 'tb.transaction_no',
            2 => 'lft.username',
            3 => 'rgt.username',
            4 => 'tb.acquired_amt',
            5 => 'tb.type'
        ];
        
        $cycle = Member::find($id)->latest_pair_cycle;
        $cycleId = $cycle->id;
        if($request->has('cycle_id')) {
            $cycleId = $request->cycle_id;
        }
        
        $cycle = MembersPairCycle::select('starting_pair_id', 'ending_pair_id')->where('id', $cycleId)->first();
        
        if(!empty($cycle->starting_pair_id)) {
            $filteredmodel = DB::table('transaction_bonuses as tb')
                                    ->join('members_pairings as mp', 'mp.id', '=', 'tb.class_id')
                                    ->join('members as lft', 'lft.id', '=', 'mp.lft_mid')
                                    ->join('members as rgt', 'rgt.id', '=', 'mp.rgt_mid')
                                    ->join('products as prod', 'prod.id', '=', 'mp.product_id')
                                    ->where('tb.member_id', $id)
                                    ->whereIn('tb.type', ['MP', 'FP']);
            if($cycle->ending_pair_id) {
                $filteredmodel->whereBetween('tb.class_id', [$cycle->starting_pair_id, $cycle->ending_pair_id]);
            } else if ($cycle->starting_pair_id) {
                $filteredmodel->where('tb.class_id', '>=', $cycle->starting_pair_id);
            }
            $filteredmodel->select(DB::raw("tb.created_at, 
                                        tb.transaction_no,
                                        lft.username as lusername, 
                                        rgt.username as rusername,
                                        tb.type,
                                        tb.acquired_amt")
                                );

            $modelcnt = $filteredmodel->count();

            $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

            return response(['data'=> $data,
                'draw' => $request->draw,
                'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
                'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
        }

        return response(['data'=> [],
            'draw' => $request->draw,
            'recordsTotal' => 0,
            'recordsFiltered' => 0], 200);
    }
    
    /**
     * Display the list of purchased transactions of the member
     *
     * @queryParam request array required 
     * JSON request generated by DataTable
     * 
     * @queryParam id integer required
     * Member's ID
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function purchased(Request $request, $id)
    {
        $tablecols = [
            0 => 'transaction_date',
            1 => 'transaction_no',
            2 => 'transaction_type',
            3 => 'product_code',
            4 => 'total_amount',
            5 => 'payment_method|payment_source'
        ];
        
        $filteredmodel = DB::table('transactions')
                                ->where('member_id', $id)
                                ->select(DB::raw("transaction_date,  
                                                transaction_no, 
                                                transaction_type, 
                                                product_code, 
                                                total_amount,
                                                payment_method,
                                                payment_source")
                            );

        $modelcnt = $filteredmodel->count();

        $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }
    
    /**
     * Display the list of purchased transactions of the member
     *
     * @queryParam request array required 
     * JSON request generated by DataTable
     * 
     * @queryParam id integer required
     * Member's ID
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function credits(Request $request, $id)
    {
        $tablecols = [
            0 => 'a.created_at',
            1 => 'b.transaction_no',
            2 => 'a.credit_amount',
            3 => 'a.amount_paid',
            4 => 'a.status'
        ];
        
        $filteredmodel = DB::table('honorary_members as a')
                                ->join('transactions as b', 'b.id', '=', 'a.transaction_id')
                                ->where('a.member_id', $id)
                                ->select(DB::raw("a.credit_amount,  
                                                b.transaction_no, 
                                                a.amount_paid, 
                                                a.status,
                                                a.created_at")
                            );

        $modelcnt = $filteredmodel->count();

        $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }
    
    
    /**
     * Display the list of purchased transactions of the member
     *
     * @queryParam request array required 
     * JSON request generated by DataTable
     * 
     * @queryParam id integer required
     * Member's ID
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function paynamics(Request $request, $id)
    {
        $tablecols = [
            0 => 'a.created_at',
            1 => 'a.transaction_no',
            2 => 'b.name',
            3 => 'a.quantity',
            4 => 'a.total_amount',
            5 => 'a.status'
        ];
        
        $filteredmodel = DB::table('paynamics_transactions as a')
                                ->leftjoin('products as b', 'b.id', '=', 'a.product_id')
                                ->where('a.member_id', $id)
                                ->select(DB::raw("a.created_at,  
                                                a.transaction_no , 
                                                b.name, 
                                                a.quantity, 
                                                a.total_amount,
                                                a.status,
                                                a.id,
                                                a.transaction_type")
                            );

        $modelcnt = $filteredmodel->count();

        $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }
    
    public function paynamicsdetails(Request $request)
    {
        if($request->has('id')) {
            $data = PaynamicsTransaction::find($request->id);
            
            return response(['success' => true,
                    'html' => view('paynamics-transaction-details', ['data'=> $data])->render()
                ], 200);
        } else {
            return response(['success' => false], 500);
        }
    }
    
    public function checkPaynamicsTransactionStatus($id)
    {
        try
        {
            DB::beginTransaction();
            $trans = PaynamicsTransaction::find($id);

            if($trans) {
                $requestID = date('YmdHis') . $trans->id;
                $result = CashInLibrary::queryDisbursement($trans, $requestID);

                if(isset($result->queryResult)) {
                    if(isset($result->queryResult->txns)) {
                        if(isset($result->queryResult->txns->ServiceResponse)) {
                            if(isset($result->queryResult->txns->ServiceResponse->responseStatus)) { 
                                $responseStat = $result->queryResult->txns->ServiceResponse->responseStatus;
                                
                                if(in_array($responseStat->response_code, ['GR001', 'GR002'])) {
                                    $trans->status = 'S';
                
                                    switch ($trans->transaction_type)
                                    {
                                        case "Purchase":
                                            Common::processProductPurchase($trans->member, $trans->product, $trans->quantity, $trans->transaction_type, $trans->payment_method, null, $trans->total_amount, $trans->transaction_no);
                                            break;
                                        case "Activation":
                                            Common::processActivation($trans->member, $trans->product, $trans->quantity, $trans->transaction_type, $trans->payment_method, null, $trans->total_amount, $trans->transaction_no);
                                            break;
                                        case "Credit Adj":
                                            
                                            $credit = HonoraryMember::find($trans->honorary_member_id);
                                            if($credit->credit_amount > $trans->total_amount) {
                                                $totalAmount = $trans->total_amount;
                                                $diff = $credit->credit_amount - $trans->total_amount;
                                            } else {
                                                $totalAmount = $credit->credit_amount;
                                                $diff = 0;
                                            }
                                            
                                            Common::processCreditAdj($trans->member, $credit, 'Credit Adj', $trans->payment_method, null, $totalAmount, $diff);
                                            break;
                                    }
                                    
                                } else if (in_array($responseStat->response_code, ['GR033'])) {
                                    $trans->status = 'WR';
                                } else {
                                    $trans->status = 'F';
                                }
                                
                                $remarks = [];
                                if(!empty($trans->remarks)) {
                                    $remarks = explode('|', $trans->remarks);
                                }
                                array_push($remarks, date('Ymd H:i') . ' Member: ' . 'Status fetched by ' . $trans->member->username);
                                array_push($remarks, date('Ymd H:i') . ' Pynmcs D: ' . $responseStat->response_message);
                                array_push($remarks, date('Ymd H:i') . ' Pynmcs D: ' . $responseStat->response_advise);
                                $trans->remarks = implode("|", $remarks);
                                $trans->save();

                                DB::commit();
                                return redirect(route('profile.show', $trans->member_id))
                                        ->with('status-success', 'Transaction status has been verified.');
                            }
                        }
                    }
                }
                
                Log::channel('paynamicsquery')->error(serialize($result));
                throw new \Exception('Unable to translate paynamics response');
            }
            
            Log::channel('paynamicsquery')->error($id);
            throw new \Exception('Unable to retrieve transaction request.');
            
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect(route('home'))
                    ->with('status-failed', $ex->getMessage());

        }
    }
}
