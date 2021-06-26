<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Library\Modules\Paynamics;

/**
 * Description of CashoutLibrary
 *
 * @author alvin
 */
use Illuminate\Support\Facades\Log;
use App\Models\GmagAccount;
use App\Models\MembersEncashmentRequest;
use App\Library\Modules\Paynamics\DisbursementSignature;
use App\Library\Modules\SettingLibrary;
use App\Library\Common;
use Carbon\Carbon;

class CashoutLibrary {
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
    
    public static function processCashout(MembersEncashmentRequest $trans, $trackingno)
    {
        $xmlData = self::generateXmlDataCashOut($trans, $trackingno);
        
        $pl = new CashoutLibrary;
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
        
        return $result;
    }
    
    private static function generateXmlDataCashOut($trans, $trackingno)
    {
        $expirationDate = Carbon::now()->addDays(SettingLibrary::retrieve('expiry_day'))->format('Y-m-d\TH:i');
        $disbursementInfo = 'Cashout for ' . $trans->firstname . ' ' . $trans->lastname . ' with the amount of ' . $trans->amount;
        $ip = $_SERVER['SERVER_ADDR'];
        $notificationUrl = route('paynamics.noti', ['transaction_id' => $trans->id]);
        $responseUrl = route('paynamics.resp', ['transaction_id' => $trans->id]);
        $requestID =  date('YmdHis') . $trans->id;
        $disbursementMethod = $trans->disbursement_method;
        
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
                'total_amount_currency' => config('paynamics.default.currency'),
                'signature' => self::processPayoutSignatureHeader($trans, $requestID, $ip, $notificationUrl, $responseUrl, $disbursementInfo),
                'timestamp' => Carbon::now()->format('Y-m-d\TH:i:s\Z'),
                'disbursement_items' => self::generatePayoutDetails($trans, $requestID, $trackingno, $expirationDate, $disbursementInfo, $disbursementMethod)
        ];
        
        $xml = new \SimpleXMLElement('<header_request/>');
        Common::arrayToXml($data, $xml);
        return $xml->asXML();
    }

    private static function processPayoutSignatureHeader($trans, $requestID, $ip, $notificationUrl, $responseUrl, $disbursementInfo)
    {
        $signatureReq = DisbursementSignature::requestHeader($requestID, $ip, $trans->amount, $notificationUrl, $responseUrl, $disbursementInfo);
        return hash("sha512", implode('', $signatureReq));
    }
    
    private static function generatePayoutDetails($trans, $requestID, $trackingno, $expirationDate, $disbursementInfo, $disbursementMethod)
    {
        $sender = GmagAccount::where('should_use', 1)->first();
        
        $data = [
            'request_id' => $requestID,
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
            'currency' => config('paynamics.default.currency'),
            'disbursement_method' => $disbursementMethod,
            'disbursement_info' => $disbursementInfo,
            'fund_source' => config('paynamics.default.fund_source'),
            'reason_for_transfer' => 'Cashout',
            'signature' => self::processPayoutSignatureDetails($trans, $sender, $requestID, $trackingno, $expirationDate, $disbursementInfo, $disbursementMethod)
        ];
        
        switch($disbursementMethod) {
            case "GCASH":
                $data['gcash_account_no'] = $trans->reference1;
                break;
            case "PXP":
                $data['wallet_id'] = $trans->reference1;
                $data['wallet_account_no'] = $trans->reference2;
                break;
            case "IBRTPP":
                $data['ibrt_bank_code'] = $trans->reference1;
                $data['bank_account_no'] = $trans->reference2;
                break;
            case "UBP":
                $data['ubp_bank_code'] = $trans->reference1;
                $data['bank_account_no'] = $trans->reference2;
                break;
            case "IBBT":
                $data['ibbt_bank_code'] = $trans->reference1;
                $data['bank_account_no'] = $trans->reference2;
                break;
            case "SBINSTAPAY":
                $data['instapay_bank_code'] = $trans->reference1;
                $data['bank_account_no'] = $trans->reference2;
                break;
            case "AUCP":
            case "GHCP":
                $data['assigned_ref'] = $trackingno;
                $data['expiry_date'] = $expirationDate;
                $data['pickup_center'] = $trans->reference1;                
                break;
        }
        
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
    
    
    private static function processPayoutSignatureDetails($trans, $sender, $requestID, $trackingno, $expirationDate, $disbursementInfo, $disbursementMethod)
    {
        $signatureReq = [];
        switch($disbursementMethod) {
            case "GCASH":
                $signatureReq = DisbursementSignature::requestGcash($requestID, $sender, $trans, $disbursementMethod, $disbursementInfo);
                break;
            case "PXP":
                $signatureReq = DisbursementSignature::requestPxp($requestID, $sender, $trans, $disbursementMethod, $disbursementInfo);
                break;
            case "CEBCP":
            case "BDOSMCP":
            case "MLCP":
                $signatureReq = DisbursementSignature::requestBayadCenters($requestID, $sender, $trans, $disbursementMethod, $disbursementInfo);                
                break;
            case "IBRTPP":
            case "UBP":
            case "IBBT":
            case "SBINSTAPAY":
                $signatureReq = DisbursementSignature::requestBanks($requestID, $sender, $trans, $disbursementMethod, $disbursementInfo);                
                break;
            case "AUCP":
            case "GHCP":
                $signatureReq = DisbursementSignature::requestPickupCenters($requestID, $trackingno, $expirationDate, $sender, $trans, $disbursementMethod, $disbursementInfo);
                break;
        }
        
        $sign = hash("sha512", implode('', $signatureReq));
        
        return $sign;
    }
}
