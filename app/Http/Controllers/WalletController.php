<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\EncashmentRequest;
use App\Models\MembersEncashmentRequest;
use App\Library\DataTables;
use App\Rules\VerifyTransactionLimit;
use App\Rules\VerifyBankNo;

/**
 * @group Members/E-Wallet
 *
 */
class WalletController extends Controller
{
    const MINIMUM_REQUEST_AMOUNT = 500;
    
    /**
     * Display encashment request form
     * 
     */
    public function index()
    {
        $member = Auth::user();
        $ghcppicksenters = DB::table('pickup_centers')->select(['code', 'description'])->where('type', 'GHCP')->whereNull('deleted_at')->orderBy('sequence')->get();
        $aucppicksenters = DB::table('pickup_centers')->select(['code', 'description'])->where('type', 'AUCP')->whereNull('deleted_at')->orderBy('sequence')->get();
        $disbursementMethod = DB::table('paynamics_disbursement_methods')->select(['method', 'name'])->whereNull('deleted_at')->orderBy('sequence')->get();
        $ibtttpBanks = DB::table('paynamics_disbursement_method_bank_codes')->select(['code', 'name'])->where('method', 'IBRTPP')->whereNull('deleted_at')->orderBy('sequence')->get();
        $ubpBanks = DB::table('paynamics_disbursement_method_bank_codes')->select(['code', 'name'])->where('method', 'UBP')->whereNull('deleted_at')->orderBy('sequence')->get();
        $ibbtBanks = DB::table('paynamics_disbursement_method_bank_codes')->select(['code', 'name'])->where('method', 'IBBT')->whereNull('deleted_at')->orderBy('sequence')->get();
        $instaBanks = DB::table('paynamics_disbursement_method_bank_codes')->select(['code', 'name'])->where('method', 'SBINSTAPAY')->whereNull('deleted_at')->orderBy('sequence')->get();
        
        return view('wallet-form', [
            'member' => $member, 
            'minimum_req' => self::MINIMUM_REQUEST_AMOUNT, 
            'disbursementmethods' => $disbursementMethod,
            'ibttpBanks' => $ibtttpBanks,
            'ubpBanks' => $ubpBanks,
            'ibbtBanks' => $ibbtBanks,
            'instaBanks' => $instaBanks, 
            'ghcppicksenters' => $ghcppicksenters,
            'aucppicksenters' => $aucppicksenters]);
    }
    

    /**
     * Process encashment request
     * 
     * @queryParam source string required
     * Wallet source. Example:Direct Referral
     * 
     * @queryParam amount string required
     * Requested amount. Example:1000
     * 
     * @queryParam req_type string required
     * Payment type. Example: Cheque
     * 
     * @queryParam name string required
     * Member's Fullname. Example Jon Snow
     * 
     * @queryParam mobile string required
     * Member's contact no. Example: 09091232456
     * 
     * @queryParam password string required
     * Member's password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postEncashment(EncashmentRequest $request)
    {
        try
        {
            DB::beginTransaction();
            
            if(Auth::user()->has_credits) {
                throw new \Exception('You still have credit balance to settle. Please settle the amount thru your pofile page.');
            }
            
            $validator = $this->validateDisburementRequirement($request->all());
            
            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }
            
            $data = $request->only(
                            'source', 
                            'amount', 
                            'disbursement_method', 
                            'firstname', 
                            'middlename', 
                            'lastname', 
                            'address1', 
                            'address2',
                            'city', 
                            'state', 
                            'country', 
                            'zip', 
                            'mobile', 
                            'email');
            $data['member_id'] = Auth::id();
            
            switch($request->disbursement_method) {
                case "GCASH":
                    $data['reference1'] = $request->gcash_no;
                    break;
                case "PXP":
                    $data['reference1'] = $request->pxp_wallet_id;
                    $data['reference2'] = $request->pxp_wallet_account_no;
                    break;
                case "IBRTPP":
                    $data['reference1'] = $request->ibrtpp_bank_code;
                    $data['reference2'] = $request->ibrtpp_bank_number;
                    break;
                case "UBP":
                    $data['reference1'] = $request->ubp_bank_code;
                    $data['reference2'] = $request->ubp_bank_number;
                    break;
                case "IBBT":
                    $data['reference1'] = $request->ibbt_bank_code;
                    $res = $this->checkForLeadingZeroes($request->disbursement_method, $request->ibbt_bank_code);
                    if($res['has_leading_zeroes']) {
                        $data['reference2'] = str_pad($request->ibbt_bank_number, $res['max_length'], "0", STR_PAD_LEFT);
                    } else {
                        $data['reference2'] = $request->ibbt_bank_number;
                    }
                    break;
                case "SBINSTAPAY":
                    $data['reference1'] = $request->insta_bank_code;
                    $res = $this->checkForLeadingZeroes($request->disbursement_method, $request->insta_bank_code);
                    if($res['has_leading_zeroes']) {
                        $data['reference2'] = str_pad($request->insta_bank_number, $res['max_length'], "0", STR_PAD_LEFT);
                    } else {
                        $data['reference2'] = $request->insta_bank_number;
                    }
                    break;
                case "GHCP":
                    $data['reference1'] = $request->ghcp_pickupcenter;
                    break;
                case "AUCP":
                    $data['reference1'] = $request->aucp_pickupcenter;
                    break;
            }
            
            MembersEncashmentRequest::create($data);
            
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
    
    private function validateDisburementRequirement($postData)
    {
        switch($postData['disbursement_method']) {
            case "GCASH":
                $validator = Validator::make($postData, [
                    'amount' => [ new VerifyTransactionLimit($postData['disbursement_method']) ],
                    'gcash_no' => [ 'required', 'digits:11' ]
                ]);
                break;
            case "PXP":
                $validator = Validator::make($postData, [
                    'amount' => [ new VerifyTransactionLimit($postData['disbursement_method']) ],
                    'pxp_wallet_id' => [ 'required', 'alpha_num', 'max:30' ]
                ]);
                break;
            case "IBRTPP":
                $validator = Validator::make($postData, [
                    'amount' => [ new VerifyTransactionLimit($postData['disbursement_method']) ],
                    'ibrtpp_bank_code' => [ 'required', 'exists:paynamics_disbursement_method_bank_codes,code' ],
                    'ibrtpp_bank_number' => [ 'required', new VerifyBankNo($postData['disbursement_method'], $postData['ibrtpp_bank_code']) ]
                ]);
                break;
            case "UBP":
                $validator = Validator::make($postData, [
                    'amount' => [ new VerifyTransactionLimit($postData['disbursement_method']) ],
                    'ubp_bank_code' => [ 'required', 'exists:paynamics_disbursement_method_bank_codes,code' ],
                    'ubp_bank_number' => [ 'required', new VerifyBankNo($postData['disbursement_method'], $postData['ubp_bank_code']) ]
                ]);
                break;
            case "IBBT":
                $validator = Validator::make($postData, [
                    'amount' => [ new VerifyTransactionLimit($postData['disbursement_method']) ],
                    'ibbt_bank_code' => [ 'required', 'exists:paynamics_disbursement_method_bank_codes,code' ],
                    'ibbt_bank_number' => [ 'required', new VerifyBankNo($postData['disbursement_method'], $postData['ibbt_bank_code']) ]
                ]);
                break;
            case "SBINSTAPAY":
                $validator = Validator::make($postData, [
                    'amount' => [ new VerifyTransactionLimit($postData['disbursement_method']) ],
                    'insta_bank_code' => [ 'required', 'exists:paynamics_disbursement_method_bank_codes,code' ],
                    'insta_bank_number' => [ 'required', new VerifyBankNo($postData['disbursement_method'], $postData['insta_bank_code']) ]
                ]);
                break;
            case "GHCP":
                $validator = Validator::make($postData, [
                    'amount' => [ new VerifyTransactionLimit($postData['disbursement_method']) ],
                ]);
                break;
            case "AUCP":
                $validator = Validator::make($postData, [
                    'amount' => [ new VerifyTransactionLimit($postData['disbursement_method']) ],
                ]);
                break;
            case "CEBCP":
            case "BDOSMCP":
            case "MLCP":
                $validator = Validator::make($postData, [
                    'amount' => [ new VerifyTransactionLimit($postData['disbursement_method']) ],
                ]);
                break;
        }
            
        return $validator;
    }
    
    private function checkForLeadingZeroes($method, $code)
    {
        $data = DB::table('paynamics_disbursement_method_bank_codes')->select('length')
                    ->where([
                        'method' => $method,
                        'code' => $code,
                        'leading_zeroes' => 1,
                    ])->first();
        
        if($data) {
            return ['has_leading_zeroes' => true, 
                    'max_length' => $data->length];
        } else {
            return ['has_leading_zeroes' => false];
        }
    }
    
    public function history()
    {
        $member = Auth::user();
        
        return view('wallet-history', ['member'=> $member]);
    }
    
    
    /**
     * Display the list of encashment requests
     *
     * @queryParam request array required 
     * JSON request generated by DataTable
     * 
     * @queryParam id integer required 
     * The id of the logged in member. Example: 5
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function historydata(Request $request, $id)
    {        
        $tablecols = [
            0 => 'id',
            1 => 'created_at',
            2 => 'disbursement_method',
            3 => 'amount',
            4 => 'firstname|lastname',
            5 => 'tracking_no',
            6 => 'status',
        ];
        
        $filteredmodel = DB::table('members_encashment_requests')
                                ->where('member_id', $id)
                                ->select(DB::raw("amount, 
                                                disbursement_method, 
                                                firstname,
                                                lastname,
                                                tracking_no,
                                                status,
                                                created_at,
                                                id")
                            );
        
        if($request->has('status') && !empty($request->status)) {
            $filteredmodel->where('status', $request->status);
        }
        
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
    
    public function historydetails(Request $request)
    {
        if($request->has('id')) {
            $data = MembersEncashmentRequest::find($request->id);
            
            return response(['success' => true,
                    'html' => view('wallet-transaction-detail', ['data'=> $data])->render()
                ], 200);
        } else {
            return response(['success' => false], 500);
        }
    }
}
