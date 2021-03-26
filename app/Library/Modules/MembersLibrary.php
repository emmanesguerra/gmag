<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Library\Modules;

use App\Models\Member;
use App\Models\MembersPlacement;
use App\Library\HierarchicalDB;

/**
 * Description of MembersLibrary
 *
 * @author alvin
 */
class MembersLibrary {
    //put your code here
    
    public static function processMemberPlacement($member, $request, $registrationCode)
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
}
