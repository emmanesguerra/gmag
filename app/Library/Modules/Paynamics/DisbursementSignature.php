<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Library\Modules\Paynamics;

/**
 * Description of Signature
 *
 * @author alvin
 */
class DisbursementSignature {
    //put your code here
    const FUND_SOURCE = 'CASH_OTC_BRNCH';
    const DEFAULT_CURRENCY = 'PHP';
    
    public static function requestHeader ($requestID, $ip, $amount, $notificationUrl, $responseUrl, $disbursementInfo) 
    {
        /*
         * forSign = merchantid + request_id + merchant_ip + total_amount + notification_url + response_url+ 
                     disbursement_info + disbursement_type + disbursement_date + mkey
         */
        return [
            config('paynamics.default.PAYOUT.PYNMCS_MERCH_ID_PAYOUT'),
            $requestID,
            $ip,
            $amount,
            $notificationUrl,
            $responseUrl,
            $disbursementInfo,
            '0', // 0 => immediate, 1 => scheduled
            '', // only if type = 1
            config('paynamics.default.PAYOUT.PYNMCS_MERCH_KEY_PAYOUT')
        ];
    }
    
    public static function responseHeader () 
    {
        /*
         * forSign = merchantid + request_id + response_id + timestamp + response_code + response_message + mkey
         */
    }
    
    public static function requestGcash ($requestID, $sender, $trans, $disbursementMethod, $disbursementInfo) 
    {
        /*
         * forSign = request_id + sender_fname + sender_lname + sender_mname + sender_address1 + 
         *          sender_addrees2 + sender_phone + disbursement_amount + currency + disbursement_method + 
         *          gcash_account_no + fund_source + reason_for_transfer + disbursement_info + mkey
         */
        return [
            $requestID,
            $sender->firstname,
            $sender->lastname,
            $sender->middlename,
            $sender->address1,
            $sender->address2,
            $sender->mobile,
            $trans->amount,
            config('paynamics.default.currency'),
            $disbursementMethod,
            $trans->reference1,
            config('paynamics.default.fund_source'),
            'Cashout',
            $disbursementInfo,
            config('paynamics.default.PAYOUT.PYNMCS_MERCH_KEY_PAYOUT')
        ];
    }
    
    public static function requestPxp ($requestID, $sender, $trans, $disbursementMethod, $disbursementInfo) 
    {
        /*
         * forSign = request_id + sender_fname + sender_lname + sender_mname + sender_address1 + 
         *          sender_addrees2 + sender_phone + disbursement_amount + currency + disbursement_method + 
         *          wallet_id + wallet_account_no + fund_source + reason_for_transfer + disbursement_info + mkey
         */
        return [
            $requestID,
            $sender->firstname,
            $sender->lastname,
            $sender->middlename,
            $sender->address1,
            $sender->address2,
            $sender->mobile,
            $trans->amount,
            config('paynamics.default.currency'),
            $disbursementMethod,
            $trans->reference1,
            $trans->reference2,
            config('paynamics.default.fund_source'),
            'Cashout',
            $disbursementInfo,
            config('paynamics.default.PAYOUT.PYNMCS_MERCH_KEY_PAYOUT')
        ];
    }
    
    /*
     * CEBCP, BDOSMPC, MLPC
     */
    public static function requestBayadCenters ($requestID, $sender, $trans, $disbursementMethod, $disbursementInfo) 
    {
        /*
         * forSign = request_id + sender_fname + sender_lname + sender_mname + sender_address1 + 
         *          sender_addrees2 + sender_phone + disbursement_amount + currency + disbursement_method + 
         *          fund_source + reason_for_transfer + disbursement_info + mkey
         */
        return [
            $requestID,
            $sender->firstname,
            $sender->lastname,
            $sender->middlename,
            $sender->address1,
            $sender->address2,
            $sender->mobile,
            $trans->amount,
            config('paynamics.default.currency'),
            $disbursementMethod,
            config('paynamics.default.fund_source'),
            'Cashout',
            $disbursementInfo,
            config('paynamics.default.PAYOUT.PYNMCS_MERCH_KEY_PAYOUT')
        ];
    }
    
    /*
     * INSTAPAY, IBBT, UBP, IBRTPP, BNBIFT
     */
    public static function requestBanks ($requestID, $sender, $trans, $disbursementMethod, $disbursementInfo) 
    {
        /*
         * forSign = request_id + sender_fname + sender_lname + sender_mname + sender_address1 + 
         *          sender_addrees2 + sender_phone + disbursement_amount + currency + disbursement_method + 
         *          bank_account_no + fund_source + reason_for_transfer + disbursement_info + mkey
         */
        return [
            $requestID,
            $sender->firstname,
            $sender->lastname,
            $sender->middlename,
            $sender->address1,
            $sender->address2,
            $sender->mobile,
            $trans->amount,
            config('paynamics.default.currency'),
            $disbursementMethod,
            $trans->reference2,
            config('paynamics.default.fund_source'),
            'Cashout',
            $disbursementInfo,
            config('paynamics.default.PAYOUT.PYNMCS_MERCH_KEY_PAYOUT')
        ];
    }
    
    /*
     * GHCP, AUCP
     */
    public static function requestPickupCenters ($requestID, $trackingno, $expirationDate, $sender, $trans, $disbursementMethod, $disbursementInfo) 
    {
        /*
         * forSign = request_id + assigned_ref + expiry_date + pickup_center + sender_fname + 
         *          sender_lname + sender_mname + sender_address1 + sender_addrees2 + sender_phone + 
         *          disbursement_amount + currency + disbursement_method + fund_source + 
         *          reason_for_transfer + disbursement_info + mkey
         */
        return [
            $requestID,
            $trackingno,
            $expirationDate,
            $trans->reference1,
            $sender->firstname,
            $sender->lastname,
            $sender->middlename,
            $sender->address1,
            $sender->address2,
            $sender->mobile,
            $sender->amount,
            config('paynamics.default.currency'),
            $disbursementMethod,
            config('paynamics.default.fund_source'),
            'Cashout',
            $disbursementInfo,
            config('paynamics.default.PAYOUT.PYNMCS_MERCH_KEY_PAYOUT')
        ];
    }
    
    /*
     * ALL
     */
    public static function responseDisbursement () 
    {
        /*
         * forSign =  merchantid + request_id + response_id + timestamp + response_code + 
         *          response_message + processor_response_id + disbursement_data + mkey
         */
    }
    
    public static function cancelDisbursementRequest($trans, $requestID, $notificationUrl, $responseUrl)
    {
        /*
         * forSign =   merchant_id + request_id + org_trxid + org_trxid2 + notification_url + response_url + mkey
         */
        return [
            config('paynamics.default.PAYOUT.PYNMCS_MERCH_ID_PAYOUT'),
            $requestID,
            $trans->paynamicsInitialResponse->hed_response_id,
            '',
            $notificationUrl,
            $responseUrl,
            config('paynamics.default.PAYOUT.PYNMCS_MERCH_KEY_PAYOUT')
        ];
    }
    
    public static function cancelDisbursementResponse()
    {
        /*
         * forSign = merchant_id + request_id + response_id + timestamp + response_code + response_message + mkey
         */
    }
    
    public static function singleQueryRequest($trans, $requestID)
    {
        /*
         * forSign = merchantid + request_id + org_trxid + org_trxid2 + mkey
         */
        return [
            config('paynamics.default.PAYOUT.PYNMCS_MERCH_ID_PAYOUT'),
            $requestID,
            $trans->paynamicsInitialResponse->det_response_id,
            $trans->generated_req_id,
            config('paynamics.default.PAYOUT.PYNMCS_MERCH_KEY_PAYOUT')
        ];
    }
    
    public static function retryDisbursementRequest($trans, $requestID, $ip, $notificationUrl, $responseUrl, $disbursementInfo)
    {
        /*
         * forSign = merchantid + merchant_ip + request_id + notification_url + response_url + org_response_id + disbursement_info + mkey
         */
        return [
            config('paynamics.default.PAYOUT.PYNMCS_MERCH_ID_PAYOUT'),
            $ip,
            $requestID,
            $notificationUrl,
            $responseUrl,
            $trans->paynamicsInitialResponse->det_response_id,
            $disbursementInfo,
            config('paynamics.default.PAYOUT.PYNMCS_MERCH_KEY_PAYOUT')
        ];
    }
    
    public static function retryDisbursementResponse()
    {
        /*
         * forSign = merchant_id + request_id + response_id + timestamp + response_code + response_message + processor_response_id + mkey
         */
    }
    
    public static function retrieveAccountBalanceRequest()
    {
        /*
         * forSign = merchantid + request_id + merchant_ip + source_processor_account + mkey
         */
    }
    
    public static function retrieveDisbursementResponse()
    {
        /*
         * forSign =  merchant_id + request_id + response_id + timestamp + response_code + response_message + mkey
         */
    }
    
    public static function retrieveTransactionHistoryRequest()
    {
        /*
         * forSign = merchantid + request_id + merchant_ip + date_from + date_to + transaction_type + 
         *          range_limit + filter_by_responsecode + filter_by_processor + pagination_info + mkey
         */
    }
    
    public static function retrieveTransactionHistoryResponse()
    {
        /*
         * forSign = merchant_id + request_id + response_id + total_number + more_data + timestamp + 
         *          response_code + response_message + mkey
         */
    }
    
    public static function retrieveProcessorStatusRequest()
    {
        /*
         * forSign = merchantid + request_id + merchant_ip + source_processor_account + mkey
         */
    }
    
    public static function retrieveProcessorStatusResponse()
    {
        /*
         * forSign = merchant_id + request_id + response_id + timestamp + response_code + response_message + mkey
         */
    }
    
    public static function notificationConfirmation($trans, $notificationStatus, $timestamp)
    {
        /*
         * forSign = mechantid + request_id + response_id + notification_status + timestamp + mkey
         */
        return [
            config('paynamics.default.PAYOUT.PYNMCS_MERCH_ID_PAYOUT'),
            $trans->generated_req_id,
            $trans->paynamicsInitialResponse->det_response_id,
            $notificationStatus,
            $timestamp,
            config('paynamics.default.PAYOUT.PYNMCS_MERCH_KEY_PAYOUT')
        ];
    }
}
