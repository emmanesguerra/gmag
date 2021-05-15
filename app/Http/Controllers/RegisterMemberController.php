<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterMemberRequest;
use App\Library\Modules\MembersLibrary;
use App\Library\Modules\TransactionLibrary;
use App\Models\Member;
use App\Models\RegistrationCode;


/**
 * @group Genealogy List
 *
 */
class RegisterMemberController extends Controller
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
     * Display the Member's registration form for new member
     * 
     * - Once an account is registered, he/she will be place depends on which location the SignUp link is clicked.
     * - New member's created in this form will be forced to change their password on their initial login.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->has('target_id') && $request->has('position')) {
            $username = Member::select('username')->where('id', $request->target_id)->first();
            $position = $request->position;

            return view('register-member', ['username' => $username, 'position' => $position, 'targetId' => $request->target_id]);
        }
        abort(403, 'Unauthorized action.');
    }

    /**
     * Register the newly created member.
     * 
     * @queryParam username string required
     * Member's username. Example:jonsnow
     * 
     * @queryParam sponsor string required
     * Username of the sponsor. Example:goldenmagtop
     * 
     * @queryParam placement string required
     * Username of the member he/she will be under to. Example:goldenmagtop
     * 
     * @queryParam position string required
     * Position of the member.  Example:L,R
     * 
     * @queryParam firstname string required
     * Member's first name. Example:Jon
     * 
     * @queryParam middlename string required
     * Member's middlename. Example:M
     * 
     * @queryParam lastname string required
     * Member's lastname. Example:Snow
     * 
     * @queryParam address string required
     * Member's address. Example:South Park Ave.
     * 
     * @queryParam email email required
     * Member's email address. Example: jon@example.com
     * 
     * @queryParam mobile number required
     * Member's contact info. Example:09091234567
     * 
     * @queryParam pincode1 string required
     * 8 Char Registracode #1. Example:SL25SD8D
     * 
     * @queryParam pincode2 string required
     * 8 Char Registracode #2. Example:63WER8F$
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterMemberRequest $request)
    {
        $sponsor = Member::select('id')->where('username', $request->sponsor)->first();

        $registrationCode = RegistrationCode::select('id', 'is_used', 'product_id', 'remarks')->where([
            'pincode1' => $request->pincode1, 
            'pincode2' => $request->pincode2,
        ])->first();
            
        try
        {
            if($registrationCode) {
                if(!$registrationCode->is_used) {
                    DB::beginTransaction();

                    $member = MembersLibrary::insertMember($registrationCode, $request, 'gmag12345678', $sponsor);
                    
                    $placement = MembersLibrary::processMemberPlacement($member, $registrationCode, $request);
                    
                    MembersLibrary::registerMemberPairingCycle($member);
                    
                    MembersLibrary::updateMemberRegistrationCode($member, $registrationCode);
                    
                    MembersLibrary::searchForTodaysPair($member->placement->placement_id);
                    
                    TransactionLibrary::saveDirectReferralBonus($member);
                    
                    TransactionLibrary::saveEncodingBonus($member);

                    DB::commit();
                    
                    return redirect(route('gtree.index', ['top'=>$request->targetId, 'r'=>1]))
                            ->with('status-success', 'This member "' . $request->username . '" was added under "' . $request->placement . '" account');
                    
                } else {
                    throw new \Exception("Pincodes are already used");
                }
            } else {
                throw new \Exception("Pincodes did not match");
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
