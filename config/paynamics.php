<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'default' => [
        'fund_source' => 'CASH_OTC_BRNCH',
        'currency' => 'PHP',
        'PAYOUT' => [
            'PYNMCS_DASHBRD_URL_PAYOUT' => env('PYNMCS_DASHBRD_URL_PAYOUT'),
            'PYNMCS_UNAME_PAYOUT' => env('PYNMCS_UNAME_PAYOUT'),
            'PYNMCS_PSWD_PAYOUT' => env('PYNMCS_PSWD_PAYOUT'),
            'PYNMCS_MERCH_ID_PAYOUT' => env('PYNMCS_MERCH_ID_PAYOUT'),
            'PYNMCS_MERCH_KEY_PAYOUT' => env('PYNMCS_MERCH_KEY_PAYOUT'),
        ],
        'PAYIN' => [
            'PYNMCS_DASHBRD_URL_PAYIN' => env('PYNMCS_DASHBRD_URL_PAYIN'),
            'PYNMCS_UNAME_PAYIN' => env('PYNMCS_UNAME_PAYIN'),
            'PYNMCS_PSWD_PAYIN' => env('PYNMCS_PSWD_PAYIN'),
            'PYNMCS_MERCH_ID_PAYIN' => env('PYNMCS_MERCH_ID_PAYIN'),
            'PYNMCS_MERCH_KEY_PAYIN' => env('PYNMCS_MERCH_KEY_PAYIN'),
            'PYNMCS_MERCH_NAME_PAYIN' => env('PYNMCS_MERCH_NAME_PAYIN'),
            'PYNMCS_MERCH_COMP_NAME_PAYIN' => env('PYNMCS_MERCH_COMP_NAME_PAYIN'),
            'PYNMCS_MERCH_ENDPOINT_PAYIN' => env('PYNMCS_MERCH_ENDPOINT_PAYIN'),
            'PYNMCS_MERCH_ENDPOINT_PAYIN_QUERY' => env('PYNMCS_MERCH_ENDPOINT_PAYIN_QUERY')
        ],
        'PYNMCS_ENV' => env('PYNMCS_ENV'),
    ],    

];
