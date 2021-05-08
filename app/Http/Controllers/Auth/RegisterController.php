<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Library\Modules\MembersLibrary;
use App\Library\Modules\TransactionLibrary;
use App\Models\Member;
use App\Models\RegistrationCode;
use App\Http\Requests\MemberRegistrationRequest;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
            'sponsor' => ['required', 'string', 'exists:members,username'],
            'placement' => ['required', 'string', 'exists:members,username'],
            'position' => ['required', 'in:L,R'],
            'firstname' => ['required', 'string', 'max:50'],
            'middlename' => ['required', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'mobile' => ['required', 'numeric'],
            'pincode1' => ['required', 'string', 'exists:registration_codes,pincode1'],
            'pincode2' => ['required', 'string', 'exists:registration_codes,pincode2'],
        ]);
    }
    
    public function showRegistrationForm(Request $request)
    {
        $member = [];
        $hasSponsor = false;
        if($request->has('ref')) {
            $member = Member::where('referral_code', $request->ref)->first();
            if($member) {
                $hasSponsor = true;
            } else {
                echo "<script>alert('Referrence code is invalid')</script>";
            }
        }
        
        return view('auth.register', ['member' => $member, 'hasSponsor' => $hasSponsor]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function register(MemberRegistrationRequest $request)
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
                    
                    $member = MembersLibrary::insertMember($registrationCode, $request, $request->password, $sponsor, false);
                    
                    $placement = MembersLibrary::processMemberPlacement($member, $registrationCode, $request);
                    
                    $this->guard()->login($member);
                    
                    MembersLibrary::registerMemberPairingCycle($member);
                    
                    MembersLibrary::updateMemberRegistrationCode($member, $registrationCode);
                    
                    MembersLibrary::searchForTodaysPair($member->placement->placement_id);
                    
                    TransactionLibrary::saveDirectReferralBonus($member);
                    
                    TransactionLibrary::saveEncodingBonus($member);
                    
                    DB::commit();
                    
                    return redirect($this->redirectPath());
                    
                } else {
                    throw new \Exception("Pincodes are already used");
                }
            } else {
                throw new \Exception("Pincodes did not match");
            }
        } catch (\Exception $ex) {
            DB::rollback();
            
            return redirect()->route('register','#accesscodes')
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }
}
