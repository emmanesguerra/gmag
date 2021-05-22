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

class PaynamicsLibrary {
    //put your code here
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
}
