<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Library\Modules\Paynamics;

/**
 * Description of Common
 *
 * @author alvin
 */
class CommonPynmcs {
    //put your code here
    
    public static function isSuccessfulResp($data)
    {
        if(in_array($data['header_response']['response_code'], self::successfulResponseCodes())) {
            return true;
        }
        
        return false;
    }
    
    public static function isRetriableResp($data)
    {
        if(in_array($data['header_response']['response_code'], self::retriableResponseCodes())) {
            return true;
        }
        
        return false;
    }
    
    public static function successfulResponseCodes()
    {
        return [
            'GR001',
            'GR002',
            'GR033',
            'GR035',
            'GR044',
        ];
    }
    
    public static function retriableResponseCodes()
    {
        return [
            'GR004',
            'GR008',
            'GR023',
            'GR027',
            'GR040',
            'RM003',
        ];
    }
    
    public static function constructRemarks($data)
    {
        $str = date('Ymd H:i') . ' Pynmcs H: ' . $data['header_response']['response_message'];
        
        foreach($data['details_response'] as $details) {
            if(isset($details['response_code'])) {
                $str .= '<br />' . date('Ymd H:i') . ' Pynmcs D: ' . $details['response_message'];
            }
        }
        
        return $str;
    }
}
