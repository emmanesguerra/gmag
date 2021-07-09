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
        Log::channel('paynamics')->info($encodedRequest);
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
        $notificationUrl = route('paynamics.member.noti', ['transaction_id' => $trans->id]);
        $responseUrl = route('paynamics.member.resp', ['transaction_id' => $trans->id]);
        $cancelUrl = route('paynamics.member.cancel', ['transaction_id' => $trans->id]);
        $mtacUrl = route('terms.and.condition');
        $requestID = date('YmdHis') . $trans->id;
        
        $data = [
            'mid' => env('PYNMCS_MERCH_ID_PAYIN'),
            'request_id' => $requestID,
            'ip_address' => $serverip,
            'notification_url' => $notificationUrl,
            'response_url' => $responseUrl,
            'cancel_url' => $cancelUrl,
            'mtac_url' => $mtacUrl,
            'fname' => $trans->member->firstname,
            'lname' => $trans->member->lastname,
            'mname' => $trans->member->middlename,
            'address1' => $trans->member->address1,
            'address2' => $trans->member->address2,
            'city' => $trans->member->city,
            'state' => $trans->member->state,
            'country' => $trans->member->country,
            'zip' => $trans->member->zip,
            'email' => $trans->member->email,
            'phone' => $trans->member->mobile,
            'mobile' => $trans->member->mobile,
            'client_ip' => $clientip,
            'amount' => number_format(($trans->total_amount), 2, '.', $thousands_sep = ''),
            'currency' => self::DEFAULT_CURRENCY,
            'pmethod' => implode(',', $request->payinmethod_name),
            'expiry_limit' => $expirationDate,
            'trxtype' => 'sale',
            'mlogo_url' => asset('favicon.ico'),
            'orders' => [
                [
                    'items' => [
                        'Items' => [
                            'itemname' => $trans->product->name,
                            'quantity' => $trans->quantity,
                            'amount' => number_format(($trans->product->price), 2, '.', $thousands_sep = '')
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
            $trans->member->firstname,
            $trans->member->lastname,
            $trans->member->middlename,
            $trans->member->address1,
            $trans->member->address2,
            $trans->member->city,
            $trans->member->state,
            $trans->member->country,
            $trans->member->zip,
            $trans->member->email,
            $trans->member->mobile,
            $clientip,
            number_format(($trans->total_amount), 2, '.', $thousands_sep = ''),
            self::DEFAULT_CURRENCY,
            'try3d',
            env('PYNMCS_MERCH_KEY_PAYIN')
        ];

        $signatureText = implode('', $signature);
        $hash = hash("sha512", $signatureText);
        
        return $hash;
    }
}
