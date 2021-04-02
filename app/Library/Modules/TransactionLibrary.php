<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Library\Modules;

/**
 * Description of TransactionLibrary
 *
 * @author alvin
 */
use App\Models\Member;
use App\Models\MembersPlacement;
use App\Models\Transaction;
use App\Models\TransactionBonus;
use App\Library\Modules\SettingLibrary;

class TransactionLibrary {
    //put your code here
    
    public static function saveProductPurchase(Member $member)
    {
        Transaction::create([
            'member_id' => $member->id,
            'product_id' => $member->placement->product_id,
            'price' => $member->placement->product->price,
            'transaction_date' => date('Y-m-d h:i:s')
        ]);
    }
    
    public static function saveDirectReferralBonus(Member $member)
    {
        TransactionBonus::create([
            'member_id' => $member->sponsor_id,
            'class_id' => $member->id,
            'class_type' => 'App\Models\Member',
            'type' => 'DR',
            'acquired_amt' => self::ComputeMemberBonus($member, 'direct_referral_bonus')
        ]);
    }
    
    public static function saveEncodingBonus(Member $member)
    {
        if($member->entry_code->assigned_to_member_id > 0) 
        {
            TransactionBonus::create([
                'member_id' => $member->entry_code->assigned_to_member_id,
                'class_id' => $member->id,
                'class_type' => 'App\Models\Member',
                'type' => 'EB',
                'acquired_amt' => self::ComputeMemberBonus($member, 'encoding_bonus')
            ]);
        }
    }
    
    private static function ComputeMemberBonus(Member $member, $bonusType)
    {
        $bonus = SettingLibrary::retrieve($bonusType);
        
        $price = $member->placement->product->price;
        return $price * $bonus;
    }
}
