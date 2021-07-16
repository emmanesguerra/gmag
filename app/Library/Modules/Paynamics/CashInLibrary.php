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
        $requestID = date('YmdHis') . $trans->id;
        $trans->generated_req_id = $requestID;
        $trans->save();
        
        $xmlData = self::generateXmlDataCashIn($trans, $request, $requestID);
        Log::channel('paynamics')->info($xmlData);
        $encodedRequest = base64_encode($xmlData);
        Log::channel('paynamics')->info($encodedRequest);
        $postData = [
            'paymentrequest' => $encodedRequest
        ];
        
        return $postData;
    }
    
    private static function generateXmlDataCashIn($trans, $request, $requestID)
    {
        $expirationDate = Carbon::now()->addDays(SettingLibrary::retrieve('expiry_day'))->format('Y-m-d\TH:i');
        $serverip = $request->server('SERVER_ADDR');
        $clientip = $request->ip();
        $notificationUrl = route('paynamics.member.noti', ['transaction_id' => $trans->id]);
        $responseUrl = route('paynamics.member.resp', ['transaction_id' => $trans->id]);
        $cancelUrl = route('paynamics.member.cancel', ['transaction_id' => $trans->id]);
        $mtacUrl = route('terms.and.condition');
        
        if($trans->transaction_type == 'Credit Adj') {
            $itemName = 'Credit Adjustment';
            $totalTAmount = $trans->total_amount;
        } else {
            $itemName = $trans->product->name;
            $totalTAmount = $trans->product->price;
        }
        
        $data = [
            'mid' => config('paynamics.default.PAYIN.PYNMCS_MERCH_ID_PAYIN'),
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
                            'itemname' => $itemName,
                            'quantity' => $trans->quantity,
                            'amount' => number_format(($totalTAmount), 2, '.', $thousands_sep = '')
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
            config('paynamics.default.PAYIN.PYNMCS_MERCH_ID_PAYIN'),
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
            config('paynamics.default.PAYIN.PYNMCS_MERCH_KEY_PAYIN')
        ];
        Log::channel('paynamics')->info($signature);

        $signatureText = implode('', $signature);
        $hash = hash("sha512", $signatureText);
        
        return $hash;
    }
    
    public static function queryDisbursement(PaynamicsTransaction $trans, $requestID)
    {
        $xmlData = self::generateXmlDataQuery($trans, $requestID);
        $context = stream_context_create(array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
        ));
        $url = config('paynamics.default.PAYIN.PYNMCS_MERCH_ENDPOINT_PAYIN_QUERY');
        $soapclient = new \SoapClient($url, array('stream_context' => $context));
        $response = $soapclient->query($xmlData);
        
        return $response;
    }
    
    private static function generateXmlDataQuery($trans, $requestID)
    {           
        return [
                'merchantid' => config('paynamics.default.PAYIN.PYNMCS_MERCH_ID_PAYIN'),
                'request_id' => $requestID,
                'org_trxid' => $trans->response_id,
                'org_trxid2' => $trans->generated_req_id,
                'signature' => self::processQueryDisbursementSignature($trans, $requestID)
        ];
    }
    
    private static function processQueryDisbursementSignature($trans, $requestID)
    {
        /*
         * forSign = merchantid + request_id + org_trxid + org_trxid2 + mkey
         */
        $signature = [
            config('paynamics.default.PAYIN.PYNMCS_MERCH_ID_PAYIN'),
            $requestID,
            $trans->response_id,
            $trans->generated_req_id,
            config('paynamics.default.PAYIN.PYNMCS_MERCH_KEY_PAYIN')
        ];

        $signatureText = implode('', $signature);
        $sign = hash("sha512", $signatureText);
        
        return $sign;
    }
}
