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
use App\Models\Member;

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
    
    public static function makeTransaction($request = null, PaynamicsTransaction $trans)
    {
        $paynamicsData = [
            'merchantid' => env('PYNMCS_MERCH_ID'),
            'merchant_ip' => $_SERVER['SERVER_ADDR'],
            'request_id' => $trans->id,
            'notification_url' => route(''),
            'response_url' => route(''),
            'disbursement_info' => 'Payment ',
        ];
    }
    
    public static function processCashout(MembersEncashmentRequest $trans, $trackingno)
    {
        $expirationDate = Carbon::now()->addDays(SettingLibrary::retrieve('expiry_day'));
        $disbursementInfo = 'Cashout for ' . $trans->firstname . ' ' . $trans->lastname . ' with the amount of ' . $trans->amount;
        
        $data = [
            'header_request' => [
                'merchantid' => env('PYNMCS_MERCH_ID'),
                'merchant_ip' => Request::ip(),
                'request_id' => $trans->id,
                'notification_url' => route('paynamics.noti'),
                'response_url' => route('paynamics.resp'),
                'disbursement_info' => $disbursementInfo,
                'disbursement_type' => '0',
                'disbursement_date' => '',
                'total_amount' => $trans->amount,
                'total_amount_currency' => self::DEFAULT_CURRENCY,
                'signature' => self::processPayoutSignature($trans, $trackingno, $expirationDate, $disbursementInfo),
                'timestamp' => Carbon::now(),
                'disbursement_items' => self::generatePayoutDetails($trans, $trackingno, $expirationDate)
            ]
        ];
    }
    
    private static function processPayoutSignature($trans, $trackingno, $expirationDate, $disbursementInfo)
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
                    $trans->id,
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
                    env('PYNMCS_MERCH_KEY')
                ];
                
                break;
        }
        
        $sign = hash("sha512", implode('', $signatureReq));
        
        return $sign;
    }
    
    private static function generatePayoutDetails($trans, $trackingno, $expirationDate)
    {
        $sender = Member::find(1);
        
        return [
            'request_id' => $trans->id,
            'assigned_ref' => $trackingno,
            'expiry_date' => $expirationDate,
            'pickup_center' => $trans->pickup_center,
            'sender_fname' => '',
            'sender_lname' => 'Doing Business As',
            'sender_mname' => '',
            'sender_fname' => $trans->pickup_center,
            'sender_fname' => $trans->pickup_center,
            'sender_fname' => $trans->pickup_center,
            'sender_fname' => $trans->pickup_center
        ];
    }
}
