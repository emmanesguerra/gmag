<?php

use Illuminate\Database\Seeder;

use App\Models\PaynamicsDisbursementMethodBankCode;

class PaynamicsDisbursementMethodBankCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'IBRTPP' => [
                [
                    'code' => 'BDO',
                    'name' => 'BDO',
                    'sequence' => 1,
                    'length' => '10,11,12',
                    'leading_zeroes' => 0
                ], 
                [
                    'code' => 'BDOCC',
                    'name' => 'BDO Cash Card',
                    'sequence' => 2,
                    'length' => '16',
                    'leading_zeroes' => 0
                ]
            ],
            'UBP' => [
                [
                    'code' => 'UBP',
                    'name' => 'Union Bank of the Philippines',
                    'sequence' => 1,
                    'length' => '12',
                    'leading_zeroes' => 0
                ]
            ],
            'IBBT' => [
                [
                    'code' => 'ANZ',
                    'name' => 'ANZ Bank',
                    'sequence' => 1,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'AUB',
                    'name' => 'Asia United Bank',
                    'sequence' => 2,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'BDO',
                    'name' => 'BDO',
                    'sequence' => 3,
                    'length' => '10,11,12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'BOC',
                    'name' => 'Bank of Commerce',
                    'sequence' => 4,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'BPI',
                    'name' => 'BPI',
                    'sequence' => 5,
                    'length' => '10',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'CBC',
                    'name' => 'China Banking Corporation',
                    'sequence' => 6,
                    'length' => '10',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'CTB',
                    'name' => 'Citibank, N.A.',
                    'sequence' => 7,
                    'length' => '10',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'DB',
                    'name' => 'Deutsche Bank',
                    'sequence' => 8,
                    'length' => '10',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'DBP',
                    'name' => 'Development Bank of the Philippines.',
                    'sequence' => 9,
                    'length' => '10',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'EWB',
                    'name' => 'East West Bank',
                    'sequence' => 10,
                    'length' => '12',
                    'leading_zeroes' => 1
                ],
                [
                    'code' => 'HSB',
                    'name' => 'HSBC',
                    'sequence' => 11,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'KEB',
                    'name' => 'Korea Exchange Bank',
                    'sequence' => 12,
                    'length' => '10',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'LBP',
                    'name' => 'Land Bank',
                    'sequence' => 13,
                    'length' => '10',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'MPI',
                    'name' => 'Maybank Phils. Inc.',
                    'sequence' => 14,
                    'length' => '11',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'MET',
                    'name' => 'Metrobank',
                    'sequence' => 15,
                    'length' => '13',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'PBC',
                    'name' => 'PBCOM',
                    'sequence' => 16,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'PNB',
                    'name' => 'Philippine National Bank',
                    'sequence' => 17,
                    'length' => '10,12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'PTC',
                    'name' => 'Philtrust Bank',
                    'sequence' => 18,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'PVB',
                    'name' => 'Philippine Veterans Bank',
                    'sequence' => 19,
                    'length' => '13',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'RCB',
                    'name' => 'RCBC',
                    'sequence' => 20,
                    'length' => '16',
                    'leading_zeroes' => 1
                ],
                [
                    'code' => 'RBN',
                    'name' => 'Robinsons Bank',
                    'sequence' => 21,
                    'length' => '15',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'SEC',
                    'name' => 'Security Bank',
                    'sequence' => 22,
                    'length' => '13',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'SCB',
                    'name' => 'Standard Chartered Bank',
                    'sequence' => 23,
                    'length' => '11',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'SBA',
                    'name' => 'Sterling Bank',
                    'sequence' => 24,
                    'length' => '15,16',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'UCP',
                    'name' => 'United Coconut Planters Bank (UCPB)',
                    'sequence' => 25,
                    'length' => '10,12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'UOB',
                    'name' => 'United Overseas Bank',
                    'sequence' => 26,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
            ],
            'SBINSTAPAY' => [
                [
                    'code' => 'ALB',
                    'name' => 'All Bank',
                    'sequence' => 1,
                    'length' => '10,16',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'AUB',
                    'name' => 'Asia United Bank',
                    'sequence' => 2,
                    'length' => '12,16',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'BDO',
                    'name' => 'Banco De Oro',
                    'sequence' => 3,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'BGB',
                    'name' => 'BPI Direct BanKO, Inc., A Savings Bank',
                    'sequence' => 4,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'BOC',
                    'name' => 'Bank of Commerce',
                    'sequence' => 5,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'BPI',
                    'name' => 'Bank of the Philippine Islands / BPI Family Bank',
                    'sequence' => 6,
                    'length' => '12,16',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'BRB',
                    'name' => 'Binangonan Rural Bank (BRBDigital)',
                    'sequence' => 8,
                    'length' => '19',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'CMG',
                    'name' => 'Camalig Bank',
                    'sequence' => 9,
                    'length' => '16',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'CRD',
                    'name' => 'Card Bank',
                    'sequence' => 10,
                    'length' => '16',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'CLB',
                    'name' => 'Cebuana Lhullier Rural Bank, Inc.',
                    'sequence' => 11,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'CBC',
                    'name' => 'China Bank',
                    'sequence' => 12,
                    'length' => '10,12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'CBS',
                    'name' => 'China Bank Savings',
                    'sequence' => 13,
                    'length' => '10,12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'CCB',
                    'name' => 'CTBC Bank',
                    'sequence' => 14,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'DCP',
                    'name' => 'DCPay Philippines Inc.',
                    'sequence' => 15,
                    'length' => '10,12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'DBI',
                    'name' => 'Dungganon Bank',
                    'sequence' => 16,
                    'length' => '8,10,16',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'EWB',
                    'name' => 'East West Bank',
                    'sequence' => 17,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'EWR',
                    'name' => 'East West Rural Bank',
                    'sequence' => 18,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'EQB',
                    'name' => 'Equicom Savings Bank',
                    'sequence' => 19,
                    'length' => '14',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'GBY',
                    'name' => 'Grabpay Philippines',
                    'sequence' => 20,
                    'length' => '10,11',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'GXI',
                    'name' => 'G-Xchange',
                    'sequence' => 21,
                    'length' => '11',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'LBP',
                    'name' => 'Land Bank of the Philippines',
                    'sequence' => 22,
                    'length' => '10',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'MSB',
                    'name' => 'Malayan Bank',
                    'sequence' => 23,
                    'length' => '12,23,20',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'MPI',
                    'name' => 'Maybank Phils. Inc.',
                    'sequence' => 24,
                    'length' => '11',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'MET',
                    'name' => 'Metrobank',
                    'sequence' => 25,
                    'length' => '13',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'PPI',
                    'name' => 'Paymaya Philippines Inc.',
                    'sequence' => 26,
                    'length' => '11,12,16,19',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'PBC',
                    'name' => 'PBCOM',
                    'sequence' => 27,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'PTC',
                    'name' => 'Philtrust Bank',
                    'sequence' => 28,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'PNB',
                    'name' => 'Philippine National Bank',
                    'sequence' => 29,
                    'length' => '10,12,16',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'PNS',
                    'name' => 'PNB (Savings Bank)',
                    'sequence' => 30,
                    'length' => '12,16',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'PSB',
                    'name' => 'PS Bank - Philippine Savings Bank',
                    'sequence' => 31,
                    'length' => '12',
                    'leading_zeroes' => 1
                ],
                [
                    'code' => 'PRB',
                    'name' => 'Producers Bank',
                    'sequence' => 32,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'RCI',
                    'name' => 'RCBC',
                    'sequence' => 33,
                    'length' => '16',
                    'leading_zeroes' => 1
                ],
                [
                    'code' => 'RBN',
                    'name' => 'Robinsons Bank',
                    'sequence' => 34,
                    'length' => '12,15',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'SEC',
                    'name' => 'Security Bank',
                    'sequence' => 35,
                    'length' => '13',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'SBA',
                    'name' => 'Sterling Bank',
                    'sequence' => 36,
                    'length' => '12,15,16',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'SSB',
                    'name' => 'Sun Savings Bank',
                    'sequence' => 14,
                    'length' => '12,16',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'UCP',
                    'name' => 'United Coconut Planters Bank (UCPB)',
                    'sequence' => 38,
                    'length' => '12',
                    'leading_zeroes' => 1
                ],
                [
                    'code' => 'UBP',
                    'name' => 'Union Bank of the Philippines',
                    'sequence' => 39,
                    'length' => '11,12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'BMB',
                    'name' => 'Bangko Mabuhay',
                    'sequence' => 40,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'ONB',
                    'name' => 'BDO Network Bank',
                    'sequence' => 41,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'DBP',
                    'name' => 'Development Bank of the Philippines',
                    'sequence' => 42,
                    'length' => '10',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'ING',
                    'name' => 'ING Bank N.V.',
                    'sequence' => 43,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'ISL',
                    'name' => 'Isla Bank (A Thrift Bank), Inc.',
                    'sequence' => 44,
                    'length' => '14',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'OPI',
                    'name' => 'Omnipay, Inc.',
                    'sequence' => 45,
                    'length' => '16',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'PAR',
                    'name' => 'Partner Rural Bank (Cotabato)',
                    'sequence' => 46,
                    'length' => '13',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'PBB',
                    'name' => 'Philippine Business Bank (A Savings Bank)',
                    'sequence' => 47,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'PVB',
                    'name' => 'Philippine Veterans Bank',
                    'sequence' => 48,
                    'length' => '13',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'QCB',
                    'name' => 'Queen City Development Bank',
                    'sequence' => 49,
                    'length' => '11,14,19',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'QRB',
                    'name' => 'Quezon Capital Rural Bank',
                    'sequence' => 50,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'USB',
                    'name' => 'UCPB Savings Bank',
                    'sequence' => 51,
                    'length' => '11',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'WEB',
                    'name' => 'Wealth Development Bank Corporation',
                    'sequence' => 52,
                    'length' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'RBG',
                    'name' => 'Rural Bank of Guinobatan Inc',
                    'sequence' => 53,
                    'length' => '10,12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'SPY',
                    'name' => 'Starpay Corporation',
                    'sequence' => 54,
                    'length' => '12',
                    'leading_zeroes' => 0
                ]
            ],
        ];
        
        foreach($data as $method => $banks) {
            foreach ($banks as $key => $value) {
                PaynamicsDisbursementMethodBankCode::create([
                    'method' => $method, 
                    'code' => $value['code'], 
                    'name' => $value['name'], 
                    'sequence' => $value['sequence'], 
                    'length' => $value['length'], 
                    'leading_zeroes' => $value['leading_zeroes']
                ]);
            }
        }
    }
}
