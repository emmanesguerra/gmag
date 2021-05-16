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
use App\Models\Product;
use App\Models\Member;
use App\Models\MembersPlacement;
use App\Models\MembersEncashmentRequest;
use App\Models\Transaction;
use App\Models\TransactionBonus;
use App\Models\TransactionEncashment;
use App\Library\Modules\SettingLibrary;

class TransactionLibrary {
    //put your code here    
    public static function saveProductPurchase(Member $member, $product, int $quantity, string $transactionType, string $paymentMethod, string $source = null, $totalAmount = 0)
    {
        $transaction = Transaction::create([
            'member_id' => $member->id,
            'product_id' => ($product) ? $product->id: null,
            'firstname' => $member->firstname,
            'lastname' => $member->lastname,
            'email' => $member->email,
            'product_code' => ($product) ? $product->code: null,
            'product_price' => ($product) ? $product->price: null,
            'quantity' => $quantity,
            'total_amount' => $totalAmount,
            'transaction_type' => $transactionType,
            'transaction_date' => date('Y-m-d h:i:s'),
            'payment_method' => $paymentMethod,
            'payment_source' => ($paymentMethod == 'ewallet') ? $source : null
        ]);
        
        if($transaction) {
            if($paymentMethod == 'ewallet') {
                if(empty($source)) {
                    throw new \Exception('Unable to retrieve the payment source. Please refresh the page.');
                }
                $member->$source -= $totalAmount;
                $member->purchased += $totalAmount;
                $member->total_amt -= $totalAmount;
                $member->save();
            }
        }
        
        return $transaction;
    }
    
    public static function saveDirectReferralBonus(Member $member)
    {
        $targetMember = Member::find($member->sponsor_id);
        $price = $member->placement->product->price;
        $acquiredAmt = self::ComputeMemberBonus($price, 'direct_referral_bonus');
        
        $trans = TransactionBonus::create([
            'member_id' => $member->sponsor_id,
            'class_id' => $member->id,
            'class_type' => 'App\Models\Member',
            'field1' => $member->username,
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
            $price = $member->placement->product->price;
            $acquiredAmt = self::ComputeMemberBonus($price, 'encoding_bonus');
            
            $trans = TransactionBonus::create([
                'member_id' => $member->entry_code->assigned_to_member_id,
                'class_id' => $member->id,
                'class_type' => 'App\Models\Member',
                'field1' => $member->username,
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
    
    private static function ComputeMemberBonus(int $price, string $bonusType)
    {
        $bonus = SettingLibrary::retrieve($bonusType);
        
        return $price * $bonus;
    }
    
    public static function saveEncashmentTransaction(MembersEncashmentRequest $cashreq)
    {
        $member = $cashreq->member;
        $source = $cashreq->source;
        $previousAmount = $member->$source;
        $deductedAmount = $cashreq->amount;
        $newAmount = $previousAmount - $deductedAmount;
        
        if($newAmount < 0) {
            throw new \Exception('Not enough wallet amount');
        }
        
        $trans = new TransactionEncashment();
        $trans->encashment_req_id  = $cashreq->id;
        $trans->account_name = $cashreq->name;
        $trans->account_number = $cashreq->mobile;
        $trans->transaction_number = $cashreq->tracking_no;
        $trans->previous_amount = $previousAmount;
        $trans->amount_deducted = $deductedAmount;
        $trans->new_amount = $newAmount;
        $trans->save();
        
        if($trans) {
            $member->$source -= $deductedAmount;
            $member->total_amt -= $deductedAmount;
            $member->save();
        }
    }
}
