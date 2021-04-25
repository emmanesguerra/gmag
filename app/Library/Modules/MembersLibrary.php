<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Library\Modules;

use App\Models\Member;
use App\Models\MembersPlacement;
use App\Models\RegistrationCode;
use App\Models\MembersPairing;
use App\Models\MembersPairCycle;
use App\Library\HierarchicalDB;
use App\Library\Modules\SettingLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

/**
 * Description of MembersLibrary
 *
 * @author alvin
 */
class MembersLibrary {
    //put your code here
    
    public static function insertMember(RegistrationCode $registrationCode, Request $request,  $password = '', Member $sponsor, $shouldChangePassword = true)
    {
        return Member::create([
            'username' => $request->username,
            'password' => Hash::make($password),
            'sponsor_id' => $sponsor->id,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'address' => $request->address,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'registration_code_id' => $registrationCode->id,
            'must_change_password' => ($shouldChangePassword) ? 1 : 0 
        ]);
    }
    
    public static function processMemberPlacement(Member $member, RegistrationCode $registrationCode, Request $request)
    {
        $placement = Member::select('id')->where('username', $request->placement)->first();
        
        $memberPlacement = MembersPlacement::select('member_id', 'rgt', 'lft', 'lvl')->where('member_id', $placement->id)->first();
        
        $hierarchyLib = new HierarchicalDB('members_placements');

        if($memberPlacement) {
            // set left with parent's right
            $left = $memberPlacement->rgt;
            $lvl = $memberPlacement->lvl + 1;

            if($request->position == 'L') {
                // check if Position R has alreayd have a record
                $positionRMember = MembersPlacement::select('member_id', 'rgt', 'lft')->where(['placement_id' => $placement->id, 'position' => 'R'])->first();
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

        return MembersPlacement::create([
            'member_id' => $member->id,
            'placement_id' => $placement->id,
            'lft' => $left,
            'rgt' => $right,
            'lvl' => $lvl,
            'position' => $request->position,
            'product_id' => $registrationCode->product_id,
        ]);
    }
    
    public static function updateMemberRegistrationCode(Member $member, RegistrationCode $registrationCode)
    {
        $registrationCode->is_used = 1;
        $registrationCode->used_by_member_id = $member->id;
        $registrationCode->date_used = \Carbon\Carbon::now();
        $registrationCode->remarks = 'Used by: ' . $member->username;
        $registrationCode->save();
        
        return;
    }
    
    public static function searchForTodaysPair(int $memberId)
    {
        if (!empty($memberId)) {
            $member = Member::find($memberId);
            $today = date('Y-m-d');

            self::saveTodaysPair($member, $today);
        }
        return;
    }
    
    private static function saveTodaysPair(Member $member, $today)
    {
        $childL = MembersPlacement::select('id', 'member_id', 'lft', 'rgt', 'product_id', 'created_at')->where(['lft' => ($member->placement->lft + 1), 'position' => 'L'])->first();
        $childR = MembersPlacement::select('id', 'member_id', 'lft', 'rgt', 'product_id', 'created_at')->where(['rgt' => ($member->placement->rgt - 1), 'position' => 'R'])->first();
        
        if(!empty($childL) && !empty($childR))
        {
            $pairedIds = MembersPairing::select('lft_mid', 'rgt_mid')->where('member_id', $member->id)
                                    ->whereNotNull('type')
                                    ->whereDate('created_at', $today)
                                    ->get();
            
            $childrenL = MembersPlacement::select('member_id', 'product_id')->whereBetween('lft', [$childL->lft, $childL->rgt])
                                        ->whereDate('created_at', $today)
                                        ->whereNotIn('member_id', $pairedIds->pluck('lft_mid'))
                                        ->get();
            $childrenR = MembersPlacement::select('member_id', 'product_id')->whereBetween('lft', [$childR->lft, $childR->rgt])
                                        ->with([ 'product' => function($query) {
                                                $query->select('id', 'product_value');
                                            }])
                                        ->whereDate('created_at', $today)
                                        ->whereNotIn('member_id', $pairedIds->pluck('rgt_mid'))
                                        ->get();
                                            
            if(!empty($childrenL) && !empty($childrenR)) {
                /*
                 * Check for match pairs
                 */
                foreach($childrenL as $chL) {
                    foreach($childrenR as $chR) {
                        if($chR->product_id == $chL->product_id) {
                            $pair = MembersPairing::create([
                                'member_id' => $member->id,
                                'lft_mid' => $chL->member_id,
                                'rgt_mid' => $chR->member_id,
                                'product_id' => $chR->product_id,
                                'product_value' => $chR->product->product_value,
                                'type' => 'TP'
                            ]);
                            if($pair) {
                                
                                $tmpPair = MembersPairing::select('id', 'created_at')->where(['member_id' => $member->id, 'type' => null])->first();
                                if($tmpPair && $tmpPair->created_at->format('Y-m-d') == $today) {
                                    $tmpPair->delete();
                                }
                                
                                if($member->pair_date != date('Y-m-d') ) {
                                    $member->pair_ctr = 1;
                                    $member->pair_date = date('Y-m-d');
                                } else {
                                    $member->pair_ctr += 1;
                                }
                                $member->save();
                                break 2;
                            }
                        }
                    }
                }
                
                /*
                 * Check for temporary pairs
                 */
                if(!isset($pair) && count($pairedIds) == 0) {
                    /*
                     * Assuming both L and R are created today, and no pair is created. Make both L and R a temporary pair
                     */
                    if(($childL->created_at->format('Y-m-d') == $today) && 
                            ($childR->created_at->format('Y-m-d') == $today)) {
                        $exists = MembersPairing::where(['member_id' => $member->id, 'lft_mid' => $childL->member_id, 'rgt_mid' => $childR->member_id, 'type' => null])->first();
                        if(!$exists) {
                            $pair = MembersPairing::create([
                                'member_id' => $member->id,
                                'lft_mid' => $childL->member_id,
                                'rgt_mid' => $childR->member_id,
                                'product_id' => ($childL->product_id > $childR->product_id) ? $childR->product_id: $childL->product_id,
                                'product_value' => ($childL->product_id > $childR->product_id) ? $childR->product->product_value: $childL->product->product_value,
                                'type' => null
                            ]);
                        }
                    } else {
                        foreach($childrenL as $chL) {
                            foreach($childrenR as $chR) {
                                $exists = MembersPairing::where(['member_id' => $member->id, 'type' => null])->first();
                                if(!$exists) {
                                    $pair = MembersPairing::create([
                                        'member_id' => $member->id,
                                        'lft_mid' => $chL->member_id,
                                        'rgt_mid' => $chR->member_id,
                                        'product_id' => ($chL->product_id > $chR->product_id) ? $chR->product_id: $chL->product_id,
                                        'product_value' => ($chL->product_id > $chR->product_id) ? $chR->product->product_value: $chL->product->product_value,
                                        'type' => null
                                    ]);
                                }
                                break 2;
                            }
                        }
                    }
                }
            }
        }
            
        return self::searchForTodaysPair($member->placement->placement_id);
    }
    
    public static function registerMemberPairingCycle(Member $member)
    {
        $cycle = MembersPairCycle::create([
            'member_id' => $member->id,
            'start_date' => Carbon::now(),
            'max_pair' => SettingLibrary::retrieve('max_pairing_ctr'),
        ]);

        $member->pair_cycle_id = $cycle->id;
        $member->save();
    }
}
