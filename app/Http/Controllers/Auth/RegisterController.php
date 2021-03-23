<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Models\Member;
use App\Models\RegistrationCode;
use App\Library\HierarchicalDB;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MemberRegistrationRequest;

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

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function register(MemberRegistrationRequest $request)
    {
        $sponsor = Member::select('id')->where('username', $request->sponsor)->first();
        $placement = Member::select('id', 'rgt', 'lft', 'lvl')->where('username', $request->placement)->first();

        $registrationCode = RegistrationCode::select('id', 'is_used')->where([
            'pincode1' => $request->pincode1, 
            'pincode2' => $request->pincode2,
        ])->first();
            
        try
        {
            if($registrationCode) {
                if(!$registrationCode->is_used) {
                    DB::beginTransaction();


                    $hierarchyLib = new HierarchicalDB('members');

                    if($placement) {
                        // set left with parent's right
                        $left = $placement->rgt;
                        $lvl = $placement->lvl + 1;
                        
                        if($request->position == 'L') {
                            // check if Position R has alreayd have a record
                            $positionRMember = Member::select('id', 'rgt', 'lft')->where(['placement_id' => $placement->id, 'position' => 'R'])->first();
                            if($positionRMember) {
                                //set left with RMembers left
                                $left = $positionRMember->lft;
                            }
                        }
                        $hierarchyLib->updateLftPlus($left);
                        $hierarchyLib->updateRgtPlus($left);
                        
                    } else {
                        $left = $hierarchyLib->getLastRgt() + 1;
                        $lvl = 1;
                    }
                    $right = $left + 1;

                    $member = Member::create([
                        'username' => $request->username,
                        'password' => Hash::make($request->password),
                        'sponsor_id' => $sponsor->id,
                        'placement_id' => $placement->id,
                        'lft' => $left,
                        'rgt' => $right,
                        'lvl' => $lvl,
                        'position' => $request->position,
                        'firstname' => $request->firstname,
                        'middlename' => $request->middlename,
                        'lastname' => $request->lastname,
                        'address' => $request->address,
                        'email' => $request->email,
                        'mobile' => $request->mobile,
                        'registration_code_id' => $registrationCode->id,
                    ]);
                    
                    $this->guard()->login($member);
                    
                    $registrationCode->is_used = 1;
                    $registrationCode->used_by_member_id = $member->id;
                    $registrationCode->date_used = \Carbon\Carbon::now();
                    $registrationCode->remarks = 'Used by: ' . $member->username;
                    $registrationCode->save();

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
