<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Library\Modules;

/**
 * Description of PaynamicsLibrary
 *
 * @author alvin
 */
use App\Models\PaynamicsTransaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Library\Modules\SettingLibrary;
use App\Models\GmagAccount;
use App\Models\MembersEncashmentRequest;
use Illuminate\Support\Facades\Log;

class PaynamicsLibrary {
    //put your code here
    const FUND_SOURCE = 'CASH_OTC_BRNCH';
    const DEFAULT_CURRENCY = 'PHP';
    
    protected $dGateDisbursementServiceUrl;
    protected $dGateDisbursementQueryUrl;
    protected $dGateDisbursementCancelUrl;
    protected $dGateDisbursementRetryUrl;
    protected $dGateDisbursementRetriveBalanceUrl;
    protected $dGateDisbursementRetrieveTrxnHistoryUrl;
    protected $dGateDisbursementRetrieveProcessorStatusUrl;
                
    protected $alphaOneDGateDisbursementUrl;
    protected $alphaOneDGateDisbursementQueryUrl;
    protected $alphaOneDGateDisbursementCancelUrl;
    
    public function __construct() {
        if(env('PYNMCS_ENV') == 'production') {
            $this->dGateDisbursementServiceUrl = "";
            $this->dGateDisbursementQueryUrl = "";
            $this->dGateDisbursementCancelUrl = "";
            $this->dGateDisbursementRetryUrl = "";
            $this->dGateDisbursementRetriveBalanceUrl = "";
            $this->dGateDisbursementRetrieveTrxnHistoryUrl = "";
            $this->dGateDisbursementRetrieveProcessorStatusUrl = "";
                
            $this->alphaOneDGateDisbursementUrl = "";
            $this->alphaOneDGateDisbursementQueryUrl = "";
            $this->alphaOneDGateDisbursementCancelUrl = "";
        } else {
            $this->dGateDisbursementServiceUrl = "https://testpti.payserv.net/DisbursementGateTest/DisbursementImpl.svc/DisbursementServiceV2";
            $this->dGateDisbursementQueryUrl = "https://testpti.payserv.net/DisbursementGateTest/DisbursementImpl.svc/DisbursementQuery";
            $this->dGateDisbursementCancelUrl = "https://testpti.payserv.net/DisbursementGateTest/DisbursementImpl.svc/DisbursementCancel";
            $this->dGateDisbursementRetryUrl = "https://testpti.payserv.net/DisbursementGateTest/DisbursementImpl.svc/RetryDisbursementV2";
            $this->dGateDisbursementRetriveBalanceUrl = "https://testpti.payserv.net/DisbursementGateTest/DisbursementImpl.svc/RetrieveBalance";
            $this->dGateDisbursementRetrieveTrxnHistoryUrl = "https://testpti.payserv.net/DisbursementGateTest/DisbursementImpl.svc/RetrieveTrxnHistory";
            $this->dGateDisbursementRetrieveProcessorStatusUrl = "https://testpti.payserv.net/DisbursementGateTest/DisbursementImpl.svc/RetrieveProcessorStatus";
                
            $this->alphaOneDGateDisbursementUrl = "https://testpti.payserv.net/DisbursementGateTest/AlphaoneImpl.svc/Disbursement";
            $this->alphaOneDGateDisbursementQueryUrl = "https://testpti.payserv.net/DisbursementGateTest/DisbursementImpl.svc/DisbursementQuery";
            $this->alphaOneDGateDisbursementCancelUrl = "https://testpti.payserv.net/DisbursementGateTest/DisbursementImpl.svc/DisbursementCancel";
        }
    }
    
    public static function processPayin($request = null, PaynamicsTransaction $trans)
    {
        $xmlData = self::generateXmlDataCashIn($trans, $request);
        
        Log::channel('paynamics')->info($xmlData);
        
        $pl = new PaynamicsLibrary;
        
        //Initiate cURL
        $curl = curl_init(env('PYNMCS_MERCH_ENDPOINT_PAYIN'));

        //Set the Content-Type to text/xml.
        curl_setopt ($curl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlData);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);

        //Do some basic error checking.
        if(curl_errno($curl)){
            Log::channel('paynamics')->error(curl_error($curl));
            throw new Exception(curl_error($curl));
        }

        //Close the cURL handle.
        curl_close($curl);

        //Print out the response output.
        Log::channel('paynamics')->info($result);
        
        echo $result;
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
        $requestID = date('YMDHis') . $trans->id;
        
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
            'phone' => '09090529279',
            'mobile' => '09090529279',
            'client_ip' => $clientip,
            'amount' => 1000.00,
            'currency' => self::DEFAULT_CURRENCY,
            'pmethod' => 'cc',
            'expiry_limit' => $expirationDate,
            'mlogo_url' => asset('favicon.ico'),
            'orders' => [
                [
                    'items' => [
                        'itemname' => 'Item 1',
                        'quantity' => 1,
                        'amount' => 1000.00
                    ]
                ]
            ],
            'secure3d' => 'enabled',
            'signature' => self::processPayinSignatureHeader($trans, $requestID, $serverip, $notificationUrl, $responseUrl, $clientip),
        ];
        
        $xml = new \SimpleXMLElement('<Request/>');
        self::array_to_xml($data, $xml);
        return $xml->asXML();
    }

    private static function processPayinSignatureHeader($trans, $requestID, $serverip, $notificationUrl, $responseUrl, $clientip)
    {
        /*
         * forSign = merchantid + request_id + merchant_ip + total_amount + notification_url + response_url+ 
            disbursement_info + disbursement_type + disbursement_date + mkey
         */
        
        return hash("sha512", implode('+', [
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
                    '09090529279',
                    $clientip,
                    1000.00,
                    self::DEFAULT_CURRENCY,
                    'enabled',
                    env('PYNMCS_MERCH_KEY_PAYIN')
                ]));
    }
    
    public static function processCashout(MembersEncashmentRequest $trans, $trackingno)
    {
        $xmlData = self::generateXmlDataCashOut($trans, $trackingno);
        
        $pl = new PaynamicsLibrary;
        //Initiate cURL
        $curl = curl_init($pl->dGateDisbursementServiceUrl);

        //Set the Content-Type to text/xml.
        curl_setopt ($curl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlData);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);

        //Do some basic error checking.
        if(curl_errno($curl)){
            Log::channel('paynamics')->error(curl_error($curl));
            throw new Exception(curl_error($curl));
        }

        //Close the cURL handle.
        curl_close($curl);

        //Print out the response output.
        Log::channel('paynamics')->info($result);
        
    }
    
    private static function generateXmlDataCashOut($trans, $trackingno)
    {
        $expirationDate = Carbon::now()->addDays(SettingLibrary::retrieve('expiry_day'))->format('Y-m-d\TH:i');
        $disbursementInfo = 'Cashout for ' . $trans->firstname . ' ' . $trans->lastname . ' with the amount of ' . $trans->amount;
        $ip = $_SERVER['SERVER_ADDR'];
        $notificationUrl = route('paynamics.noti', ['transaction_id' => $trans->id]);
        $responseUrl = route('paynamics.resp', ['transaction_id' => $trans->id]);
        $requestID =  date('YmdHis') . $trans->id;
        
        $data = [
                'merchantid' => env('PYNMCS_MERCH_ID_PAYOUT'),
                'merchant_ip' => $ip,
                'request_id' => $requestID,
                'notification_url' => $notificationUrl,
                'response_url' => $responseUrl,
                'disbursement_info' => $disbursementInfo,
                'disbursement_type' => '0',
                'disbursement_date' => '',
                'total_amount' => $trans->amount,
                'total_amount_currency' => self::DEFAULT_CURRENCY,
                'signature' => self::processPayoutSignatureHeader($trans, $requestID, $ip, $notificationUrl, $responseUrl, $disbursementInfo),
                'timestamp' => Carbon::now()->format('Y-m-d\TH:i:s\Z'),
                'disbursement_items' => self::generatePayoutDetails($trans, $requestID, $trackingno, $expirationDate, $disbursementInfo)
        ];
        
        $xml = new \SimpleXMLElement('<header_request/>');
        self::array_to_xml($data, $xml);
        return $xml->asXML();
    }
    
    private static function array_to_xml($template_info, &$xml_template_info) 
    {
	foreach($template_info as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xml_template_info->addChild("$key");
                    self::array_to_xml($value, $subnode);
                } else {
                    self::array_to_xml($value, $xml_template_info);
                }
            } else {
                $xml_template_info->addChild("$key", "$value");
            }
        }
    }

    private static function processPayoutSignatureHeader($trans, $requestID, $ip, $notificationUrl, $responseUrl, $disbursementInfo)
    {
        /*
         * forSign = merchantid + request_id + merchant_ip + total_amount + notification_url + response_url+ 
            disbursement_info + disbursement_type + disbursement_date + mkey
         */
        
        return hash("sha512", implode('', [
                    env('PYNMCS_MERCH_ID_PAYOUT'),
                    $requestID,
                    $ip,
                    $trans->amount,
                    $notificationUrl,
                    $responseUrl,
                    $disbursementInfo,
                    '0',
                    '',
                    env('PYNMCS_MERCH_KEY_PAYOUT')
                ]));
    }
    
    
    private static function processPayoutSignatureDetails($trans, $requestID, $trackingno, $expirationDate, $disbursementInfo)
    {
        $signatureReq = [];
        switch($trans->pcenter->type) {
            case "AUCP":
            case "GHCP":
                /*
                 * forSign = request_id + assigned_ref + expiry_date + pickup_center + sender_fname + sender_lname + 
                    sender_mname + sender_address1 + sender_addrees2 + sender_phone + disbursement_amount + currency 
                    + disbursement_method + fund_source + reason_for_transfer + disbursement_info + mkey
                 */
                
                $signatureReq = [
                    $requestID,
                    $trackingno,
                    $expirationDate,
                    $trans->pickup_center,
                    $trans->firstname,
                    $trans->lastname,
                    $trans->middlename,
                    $trans->address1,
                    $trans->address2,
                    $trans->mobile,
                    $trans->amount,
                    self::DEFAULT_CURRENCY,
                    $trans->pcenter->type,
                    self::FUND_SOURCE,
                    'Cashout',
                    $disbursementInfo,
                    env('PYNMCS_MERCH_KEY_PAYOUT')
                ];
                
                break;
        }
        
        $sign = hash("sha512", implode('', $signatureReq));
        
        return $sign;
    }
    
    private static function generatePayoutDetails($trans, $requestID, $trackingno, $expirationDate, $disbursementInfo)
    {
        $sender = GmagAccount::where('should_use', 1)->first();
        
        $data = [
            'request_id' => $requestID,
            'assigned_ref' => $trackingno,
            'expiry_date' => $expirationDate,
            'pickup_center' => $trans->pickup_center,
            'sender_fname' => $sender->firstname,
            'sender_lname' => $sender->lastname,
            'sender_mname' => $sender->middlename,
            'sender_address1' => $sender->address1,
            'sender_address2' => $sender->address2,
            'sender_city' => $sender->city,
            'sender_state' => $sender->state,
            'sender_country' => $sender->country,
            'sender_zip' => $sender->zip,
            'sender_email' => $sender->email,
            'sender_phone' => $sender->mobile,
            'dob' => $sender->birthdate,
            'birthplace' => $sender->birthplace,
            'sender_nature_of_work' => $sender->nature_of_work,
            'sender_nationality' => $sender->nationality,
            'primary_kyc_doc' => ($sender->primaryDocument) ? $sender->primaryDocument->doc_type: '',
            'primary_kyc_proof' => ($sender->primaryDocument) ? asset('storage/admin/payout/proof/'.$sender->id . '/'.$sender->primaryDocument->proof): '',
            'primary_kyc_id' => ($sender->primaryDocument) ? $sender->primaryDocument->doc_id: '',
            'primary_kyc_expiry' => ($sender->primaryDocument) ? $sender->primaryDocument->expiry_date: '',
            'secondary_kyc_doc1' => ($sender->secondaryDocument1) ? $sender->secondaryDocument1->doc_type: '',
            'secondary_kyc_proof1' => ($sender->secondaryDocument1) ? asset('storage/admin/payout/proof/'.$sender->id . '/'.$sender->secondaryDocument1->proof): '',
            'secondary_kyc_id1' => ($sender->secondaryDocument1) ? $sender->secondaryDocument1->doc_id: '',
            'secondary_kyc_expiry1' => ($sender->secondaryDocument1) ? $sender->secondaryDocument1->expiry_date: '',
            'secondary_kyc_doc2' => ($sender->secondaryDocument2) ? $sender->secondaryDocument2->doc_type: '',
            'secondary_kyc_proof2' => ($sender->secondaryDocument2) ? asset('storage/admin/payout/proof/'.$sender->id . '/'.$sender->secondaryDocument2->proof): '',
            'secondary_kyc_id2' => ($sender->secondaryDocument2) ? $sender->secondaryDocument2->doc_id: '',
            'secondary_kyc_expiry2' => ($sender->secondaryDocument2) ? $sender->secondaryDocument2->expiry_date: '',
            'ben_fname' => $trans->firstname,
            'ben_lname' => $trans->lastname,
            'ben_mname' => $trans->middlename,
            'ben_address1' => $trans->address1,
            'ben_address2' => $trans->address2,
            'ben_city' => $trans->city,
            'ben_state' => $trans->state,
            'ben_country' => $trans->country,
            'ben_zip' => $trans->zip,
            'ben_email' => $trans->email,
            'ben_phone' => $trans->mobile,
            'disbursement_amount' => $trans->amount,
            'currency' => self::DEFAULT_CURRENCY,
            'disbursement_method' => $trans->pcenter->code,
            'disbursement_info' => $disbursementInfo,
            'fund_source' => self::FUND_SOURCE,
            'reason_for_transfer' => 'Cashout',
            'signature' => self::processPayoutSignatureDetails($trans, $requestID, $trackingno, $expirationDate, $disbursementInfo)
        ];
        
        $xmlData = [];
        foreach($data as $key => $value) {
            $xmlData[] = [
                'disbursement_data' => [
                    'item' => $key,
                    'value' => $value
                ]
            ];
        }
        
        return [
            'disbursement_details' =>  $xmlData
        ];
    }
}
