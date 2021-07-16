<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Library;

/**
 * Description of Common
 *
 * @author alvin
 */
use App\Library\Modules\TransactionLibrary;
use App\Library\Modules\EntryCodesLibrary;
use App\Library\Modules\MembersLibrary;
use App\Models\Member;
use App\Models\Product;
use App\Models\HonoraryMember;

class Common {
    //put your code here
    public static function splitWord($str, $width, $length = PHP_INT_MAX)
    {
	$string = wordwrap($str, $width, "|");
        return explode("|", $string, $length);
    }
    
    public static function arrayToXml($template_info, &$xml_template_info) 
    {
	foreach($template_info as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xml_template_info->addChild("$key");
                    self::arrayToXml($value, $subnode);
                } else {
                    self::arrayToXml($value, $xml_template_info);
                }
            } else {
                $xml_template_info->addChild("$key", "$value");
            }
        }
    }
    
    public static function convertXmlToJson($xml)
    {
        $xml = simplexml_load_string($xml);
        $json = json_encode($xml);
        return json_decode($json, TRUE);
    }
    
    public static function processProductPurchase(Member $member, Product $product, $quantity, $ttype, $tpaymetMethod, $tsource, $tttlAmount, $transactionno = null)
    {
        $trans = TransactionLibrary::saveProductPurchase($member, $product, $quantity, $ttype, $tpaymetMethod, $tsource, $tttlAmount, $transactionno);

        if($trans) {
            EntryCodesLibrary::createEntryCodes($product, $member->id, $quantity, 'Purchased by ' . $member->username, $trans->id);
        }
        
        return;
    }
    
    public static function processCreditAdj(Member $member, HonoraryMember $credit, $ttype, $tpaymetMethod, $tsource, $totalAmount, $diff)
    {
        $trans = TransactionLibrary::saveProductPurchase($member, null, 0, $ttype, $tpaymetMethod, $tsource, $totalAmount);

        if($trans) {
            $credit->transaction_id = $trans->id;
            $credit->amount_paid = $totalAmount;
            $credit->status = 'Paid';
            $credit->save();

            if(isset($diff) && $diff > 0) {
                MembersLibrary::createHonoraryRecord($member, $diff);
            } else {
                $member->has_credits = 0;
                $member->save();
            }

        }   
    }
}
