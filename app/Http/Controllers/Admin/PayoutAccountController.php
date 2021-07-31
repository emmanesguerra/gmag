<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Library\DataTables;
use App\Models\GmagAccount;
use App\Models\GmagAccountDocuments;
use App\Http\Requests\PayoutAccountRequest;

/**
 * @group Admin/Payout Accounts
 *
 */
class PayoutAccountController extends Controller
{
    /**
     * Display a listing of pay-out accounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.payouts.index');
    }
    
    /**
     * Return the list of recorded pay-out accounts
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
        $tablecols = [
            0 => 'a.created_at',
            1 => 'a.should_use',
            2 => 'a.firstname|a.lastname',
            3 => 'a.address1|a.address2',
            4 => 'a.city',
            5 => 'a.country',
            6 => 'a.email',
            7 => 'a.mobile',
        ];
        
        $filteredmodel = DB::table('gmag_accounts as a')
                                ->select(DB::raw("a.should_use, 
                                                a.firstname, 
                                                a.lastname,
                                                a.address1,
                                                a.address2,
                                                a.city,
                                                a.country,
                                                a.email,
                                                a.mobile,
                                                a.created_at,
                                                a.id")
                            );
        
        if($request->has('start_date') && !empty($request->start_date)) {        
            if($request->has('end_date') && !empty($request->end_date && $request->start_date != $request->end_date)) {
                $filteredmodel->whereBetween('a.created_at', [$request->start_date, $request->end_date . ' 23:59:00']);
            } else {
                $filteredmodel->whereDate('a.created_at', $request->start_date);
            }
        }

        $modelcnt = $filteredmodel->count();

        $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }

    /**
     * Show the form for creating a new pay-out accounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pdocumentTypes = DB::table('document_options')->whereNull('deleted_at')->where('is_primary', 1)->get();
        $sdocumentTypes = DB::table('document_options')->whereNull('deleted_at')->where('is_primary', 0)->get();
        
        return view('admin.payouts.create', [
            'pdocumentTypes' => $pdocumentTypes, 
            'sdocumentTypes' => $sdocumentTypes]);
    }

    /**
     * Store a newly created pay-out accounts in storage.
     * 
     * @queryParam firstname string required
     * Account firstname. Example: Jon
     * 
     * @queryParam middlename string required
     * Account middlename. Example: M
     * 
     * @queryParam lastname string required
     * Account lastname, if this is company encoded "Doing as Business As". Example: Snow
     * 
     * @queryParam birthdate string required
     * Account birth date, if this is company encoded registration date. Example: 2021-05-06
     * 
     * @queryParam email string required
     * Account email. Example: jonsnow@gmail.com
     * 
     * @queryParam mobile string required
     * Account mobile. Example: 09095123123
     * 
     * @queryParam address1 string required
     * Account address1. Example: B32 L7 North Kingslanding
     * 
     * @queryParam address2 string required
     * Account address2. Example: B32 L7 North Kingslanding
     * 
     * @queryParam address3 string required
     * Account address3. Example: B32 L7 North Kingslanding
     * 
     * @queryParam city string required
     * Account city. Example: Makati
     * 
     * @queryParam state string required
     * Account state. Example: 
     * 
     * @queryParam country string required
     * Account country. Example: PH
     * 
     * @queryParam zip string required
     * Account zip. Example: 1306 
     * 
     * @queryParam nationality string required
     * Account nationality. Example: Filipino  
     * 
     * @queryParam nature_of_work string required
     * Account nature_of_work. Example: Developer 
     * 
     * @queryParam document.*.doc string optional
     * Document proof. Example: IDP_001   
     * 
     * @queryParam document.*.idnum string optional
     * Document ID Number. Example: 0014785462   
     * 
     * @queryParam document.*.exp string optional
     * Document Expiry Date. Example: 2025-05-05
     * 
     * @queryParam document.*.doc_proof_0 string optional
     * Document Proof, uploaded file Image or document
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PayoutAccountRequest $request)
    {
        try
        {   
            $validate = $this->validateFileUploads($request);
            if(!empty($validate)) {
                throw new \Exception(implode('<br />', $validate));
            }
            
            DB::beginTransaction();
            
            $gmag = GmagAccount::create($request->only(['firstname', 'middlename', 'lastname', 
                                'birthdate', 'email', 'mobile', 'address1', 'address2', 
                                'address3', 'city', 'state', 'country', 'zip', 'birthplace',
                                'nationality', 'nature_of_work']));      
            
            foreach($request->document as $key => $docs) {
                if(!empty($docs['doc'])) {
                    $fileName = (isset($docs['proof']) ? $docs['proof']: null);
                    if($request->hasFile('doc_proof_' . $key)) {
                        $proof = $request->file('doc_proof_' . $key);
                        $fileName = 'D'.$key.'-U' . strtoupper(substr($gmag->firstname,0,7)) .'-I' . $gmag->id . '.' . $proof->getClientOriginalExtension();
                        Storage::disk('document_proof_payout')->put($gmag->id . '/'. $fileName, file_get_contents($proof));
                    }

                    GmagAccountDocuments::updateOrCreate(['account_id' => $gmag->id, 
                                                    'type' => $key + 1], 
                                                   ['doc_type' => $docs['doc'],
                                                    'doc_id' => $docs['idnum'],
                                                    'expiry_date' => $docs['exp'],
                                                    'proof' => $fileName ]);
                }
            }
            
            DB::commit();
            
            return redirect()->route('payout.accounts.index')->with('status-success', 'Account has been updated');
            
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }

    /**
     * Show the form for editing the specified pay-out accounts.
     * 
     * @queryParam id string required
     * Payout account id. Example:5
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gmag = GmagAccount::find($id);
        
        $pdocumentTypes = DB::table('document_options')->whereNull('deleted_at')->where('is_primary', 1)->get();
        $sdocumentTypes = DB::table('document_options')->whereNull('deleted_at')->where('is_primary', 0)->get();
        
        return view('admin.payouts.edit', ['gmag' => $gmag, 
            'pdocumentTypes' => $pdocumentTypes, 
            'sdocumentTypes' => $sdocumentTypes]);
    }

    /**
     * Update the specified pay-out accounts in storage.
     * 
     * @queryParam firstname string required
     * Account firstname. Example: Jon
     * 
     * @queryParam middlename string required
     * Account middlename. Example: M
     * 
     * @queryParam lastname string required
     * Account lastname, if this is company encoded "Doing as Business As". Example: Snow
     * 
     * @queryParam birthdate string required
     * Account birth date, if this is company encoded registration date. Example: 2021-05-06
     * 
     * @queryParam email string required
     * Account email. Example: jonsnow@gmail.com
     * 
     * @queryParam mobile string required
     * Account mobile. Example: 09095123123
     * 
     * @queryParam address1 string required
     * Account address1. Example: B32 L7 North Kingslanding
     * 
     * @queryParam address2 string required
     * Account address2. Example: B32 L7 North Kingslanding
     * 
     * @queryParam address3 string required
     * Account address3. Example: B32 L7 North Kingslanding
     * 
     * @queryParam city string required
     * Account city. Example: Makati
     * 
     * @queryParam state string required
     * Account state. Example: 
     * 
     * @queryParam country string required
     * Account country. Example: PH
     * 
     * @queryParam zip string required
     * Account zip. Example: 1306 
     * 
     * @queryParam nationality string required
     * Account nationality. Example: Filipino  
     * 
     * @queryParam nature_of_work string required
     * Account nature_of_work. Example: Developer 
     * 
     * @queryParam document.*.doc string optional
     * Document proof. Example: IDP_001   
     * 
     * @queryParam document.*.idnum string optional
     * Document ID Number. Example: 0014785462   
     * 
     * @queryParam document.*.exp string optional
     * Document Expiry Date. Example: 2025-05-05
     * 
     * @queryParam document.*.doc_proof_0 string optional
     * Document Proof, uploaded file Image or document
     * 
     * @queryParam id int required
     * Payout account id. Example:5
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PayoutAccountRequest $request, $id)
    {
        try
        {   
            $validate = $this->validateFileUploads($request);
            if(!empty($validate)) {
                throw new \Exception(implode('<br />', $validate));
            }
            
            DB::beginTransaction();
            
            $gmag = GmagAccount::find($id);           
            $gmag->update($request->only(['firstname', 'middlename', 'lastname', 
                                'birthdate', 'email', 'mobile', 'address1', 'address2', 
                                'address3', 'city', 'state', 'country', 'zip', 'birthplace',
                                'nationality', 'nature_of_work']));
            
            foreach($request->document as $key => $docs) {
                if(!empty($docs['doc'])) {
                    $fileName = (isset($docs['proof']) ? $docs['proof']: null);
                    if($request->hasFile('doc_proof_' . $key)) {
                        $proof = $request->file('doc_proof_' . $key);
                        $fileName = 'D'.$key.'-U' . strtoupper(substr($gmag->firstname,0,7)) .'-I' . $gmag->id . '.' . $proof->getClientOriginalExtension();
                        Storage::disk('document_proof_payout')->put($gmag->id . '/'. $fileName, file_get_contents($proof));
                    }

                    GmagAccountDocuments::updateOrCreate(['account_id' => $gmag->id, 
                                                    'type' => $key + 1], 
                                                   ['doc_type' => $docs['doc'],
                                                    'doc_id' => $docs['idnum'],
                                                    'expiry_date' => $docs['exp'],
                                                    'proof' => $fileName ]);
                }
            }
            
            DB::commit();
            
            return redirect()->route('payout.accounts.index', $id)->with('status-success', 'Account has been updated');
            
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
        
        foreach($request->document as $key => $docs) {
            if(!empty($docs['doc'])) {
                if(!$request->hasFile('doc_proof_' . $key) && !isset($docs['proof'])) {
                    $errors[] = 'Document Proof on box '.($key + 1).' is required';
                }
            }
        }

        if(!empty($errors)) {
            $response = [
                "There's something wrong with your request:",
                ""
            ];
            foreach($errors as $err) {
                array_push($response, $err);
            }
        }
        
        return $response;
    }
    
    /**
     * Activate account to use in pay-outs
     * 
     * @queryParam id string required
     * Payout account id. Example:5
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        DB::table('gmag_accounts')->where('should_use', 1)->update(['should_use' => 0]);
        DB::table('gmag_accounts')->where('id', $id)->update(['should_use' => 1]);
        
        return redirect()->route('payout.accounts.index')->with('status-success', 'Account id# '.$id.' has been set to active');
    }
}
