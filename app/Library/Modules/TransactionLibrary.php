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
            'firstname' => $member->firstname,
            'lastname' => $member->lastname,
            'email' => $member->email,
            'product_code' => $member->placement->product->code,
            'product_price' => $member->placement->product->price,
            'transaction_date' => date('Y-m-d h:i:s')
        ]);
    }
    
    public static function saveDirectReferralBonus(Member $member)
    {
        $targetMember = Member::find($member->sponsor_id);
        $price = ($member->placement->product->price > $targetMember->placement->product->price) ? $targetMember->placement->product->price: $member->placement->product->price;
        $acquiredAmt = self::ComputeMemberBonus($price, 'direct_referral_bonus');
        
        $trans = TransactionBonus::create([
            'member_id' => $member->sponsor_id,
            'class_id' => $member->id,
            'class_type' => 'App\Models\Member',
            'type' => 'DR',
            'acquired_amt' => $acquiredAmt
        ]);
        
        if($trans) {
            $targetMember->direct_referral += $acquiredAmt;
            $targetMember->total_amt += $acquiredAmt;
            $targetMember->save();
        }
    }
    
    public static function saveEncodingBonus(Member $member)
    {
        if($member->entry_code->assigned_to_member_id > 0) 
        {
            $targetMember = Member::find($member->entry_code->assigned_to_member_id);
            $price = ($member->placement->product->price > $targetMember->placement->product->price) ? $targetMember->placement->product->price: $member->placement->product->price;
            $acquiredAmt = self::ComputeMemberBonus($price, 'encoding_bonus');
            
            $trans = TransactionBonus::create([
                'member_id' => $member->entry_code->assigned_to_member_id,
                'class_id' => $member->id,
                'class_type' => 'App\Models\Member',
                'type' => 'EB',
                'acquired_amt' => $acquiredAmt
            ]);
        
            if($trans) {
                $targetMember->encoding_bonus += $acquiredAmt;
                $targetMember->total_amt += $acquiredAmt;
                $targetMember->save();
            }
        }
    }
    
    private static function ComputeMemberBonus($price, $bonusType)
    {
        $bonus = SettingLibrary::retrieve($bonusType);
        
        return $price * $bonus;
    }
}
