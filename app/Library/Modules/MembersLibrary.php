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
use App\Library\HierarchicalDB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Description of MembersLibrary
 *
 * @author alvin
 */
class MembersLibrary {
    //put your code here
    
    public static function insertMember(RegistrationCode $registrationCode, Request $request,  $password = '', Member $sponsor)
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

        MembersPlacement::create([
            'member_id' => $member->id,
            'placement_id' => $placement->id,
            'lft' => $left,
            'rgt' => $right,
            'lvl' => $lvl,
            'position' => $request->position,
            'product_id' => $registrationCode->product_id,
        ]);

        return;
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
}
