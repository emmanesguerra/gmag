<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Library\Modules\Paynamics;

/**
 * Description of CashInLibrary
 *
 * @author alvin
 */
use App\Models\PaynamicsTransaction;
use App\Library\Modules\SettingLibrary;
use App\Library\Common;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CashInLibrary {
    //put your code here
    const DEFAULT_CURRENCY = 'PHP';
    
    public static function processPayin($request = null, PaynamicsTransaction $trans)
    {
        $xmlData = self::generateXmlDataCashIn($trans, $request);
        Log::channel('paynamics')->info($xmlData);
        $encodedRequest = base64_encode($xmlData);
        $postData = [
            'paymentrequest' => $encodedRequest
        ];
        
        return $postData;
    }
    
    private static function generateXmlDataCashIn($trans, $request)
    {
        $expirationDate = Carbon::now()->addDays(SettingLibrary::retrieve('expiry_day'))->format('Y-m-d\TH:i');
        $serverip = $_SERVER['SERVER_ADDR'];
        $clientip = $request->ip();
        $notificationUrl = route('paynamics.noti', ['transaction_id' => $trans->id]);
        $responseUrl = route('paynamics.resp', ['transaction_id' => $trans->id]);
        $cancelUrl = route('paynamics.resp', ['transaction_id' => $trans->id]);
        $mtacUrl = route('paynamics.resp', ['transaction_id' => $trans->id]);
        $requestID = date('YmdHis') . $trans->id;
        
        $data = [
            'mid' => env('PYNMCS_MERCH_ID_PAYIN'),
            'request_id' => $requestID,
            'ip_address' => $serverip,
            'notification_url' => $notificationUrl,
            'response_url' => $responseUrl,
            'cancel_url' => $cancelUrl,
            'mtac_url' => $mtacUrl,
            'fname' => 'Emmanuelle',
            'lname' => 'Esguerra',
            'mname' => 'Magtibay',
            'address1' => 'Lorem ipsum comet dolor',
            'address2' => 'Lorem ipsum comet dolor',
            'city' => 'Makati',
            'state' => '',
            'country' => 'PH',
            'zip' => '',
            'email' => 'emman.esguerra2013@gmail.com',
            'phone' => '+63090529279',
            'mobile' => '+63090529278',
            'client_ip' => $clientip,
            'amount' => number_format((1000), 2, '.', $thousands_sep = ''),
            'currency' => self::DEFAULT_CURRENCY,
            'pmethod' => '',
            'expiry_limit' => $expirationDate,
            'mlogo_url' => asset('favicon.ico'),
            'orders' => [
                [
                    'items' => [
                        'Items' => [
                            'itemname' => 'Item 1',
                            'quantity' => 1,
                            'amount' => number_format((1000), 2, '.', $thousands_sep = '')
                        ]
                    ]
                ]
            ],
            'secure3d' => 'try3d',
            'signature' => self::processPayinSignatureHeader($trans, $requestID, $serverip, $notificationUrl, $responseUrl, $clientip),
        ];
        
        $xml = new \SimpleXMLElement('<Request/>');
        Common::arrayToXml($data, $xml);
        return $xml->asXML();
    }

    private static function processPayinSignatureHeader($trans, $requestID, $serverip, $notificationUrl, $responseUrl, $clientip)
    {
        /*
         * Signature = Sign(mid + request_id + ip_address + notification_url + response_url + fname 
                    + lname + mname + address1 + address2 + city + state + country + zip + email + phone + 
                    client_ip + amount + currency + secure3d + merchantkey)
         */
        $signature = [
            env('PYNMCS_MERCH_ID_PAYIN'),
            $requestID,
            $serverip,
            $notificationUrl,
            $responseUrl,
            'Emmanuelle',
            'Esguerra',
            'Magtibay',
            'Lorem ipsum comet dolor',
            'Lorem ipsum comet dolor',
            'Makati',
            '',
            'PH',
            '',
            'emman.esguerra2013@gmail.com',
            '+63090529278',
            $clientip,
            number_format((1000), 2, '.', $thousands_sep = ''),
            self::DEFAULT_CURRENCY,
            'try3d',
            env('PYNMCS_MERCH_KEY_PAYIN')
        ];
        
        Log::channel('paynamics')->info($signature);
        
        return hash("sha512", implode('', $signature));
    }
}
