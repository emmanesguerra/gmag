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
                    'legnth' => '10,11,12',
                    'leading_zeroes' => 0
                ], 
                [
                    'code' => 'BDOCC',
                    'name' => 'BDO Cash Card',
                    'sequence' => 2,
                    'legnth' => '16',
                    'leading_zeroes' => 0
                ]
            ],
            'UBP' => [
                [
                    'code' => 'UBP',
                    'name' => 'Union Bank of the Philippines',
                    'sequence' => 1,
                    'legnth' => '12',
                    'leading_zeroes' => 0
                ]
            ],
            'IBBT' => [
                [
                    'code' => 'ANZ',
                    'name' => 'ANZ Bank',
                    'sequence' => 1,
                    'legnth' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'AUB',
                    'name' => 'Asia United Bank',
                    'sequence' => 2,
                    'legnth' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'BDO',
                    'name' => 'BDO',
                    'sequence' => 3,
                    'legnth' => '10,11,12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'BOC',
                    'name' => 'Bank of Commerce',
                    'sequence' => 4,
                    'legnth' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'BPI',
                    'name' => 'BPI',
                    'sequence' => 5,
                    'legnth' => '10',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'CBC',
                    'name' => 'China Banking Corporation',
                    'sequence' => 6,
                    'legnth' => '10',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'CTB',
                    'name' => 'Citibank, N.A.',
                    'sequence' => 7,
                    'legnth' => '10',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'DB',
                    'name' => 'Deutsche Bank',
                    'sequence' => 8,
                    'legnth' => '10',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'DBP',
                    'name' => 'Development Bank of the Philippines.',
                    'sequence' => 9,
                    'legnth' => '10',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'EWB',
                    'name' => 'East West Bank',
                    'sequence' => 10,
                    'legnth' => '12',
                    'leading_zeroes' => 1
                ],
                [
                    'code' => 'HSB',
                    'name' => 'HSBC',
                    'sequence' => 11,
                    'legnth' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'KEB',
                    'name' => 'Korea Exchange Bank',
                    'sequence' => 12,
                    'legnth' => '10',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'LBP',
                    'name' => 'Land Bank',
                    'sequence' => 13,
                    'legnth' => '10',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'MPI',
                    'name' => 'Maybank Phils. Inc.',
                    'sequence' => 14,
                    'legnth' => '11',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'MET',
                    'name' => 'Metrobank',
                    'sequence' => 15,
                    'legnth' => '13',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'PBC',
                    'name' => 'PBCOM',
                    'sequence' => 16,
                    'legnth' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'PNB',
                    'name' => 'Philippine National Bank',
                    'sequence' => 17,
                    'legnth' => '10,12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'PTC',
                    'name' => 'Philtrust Bank',
                    'sequence' => 18,
                    'legnth' => '12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'PVB',
                    'name' => 'Philippine Veterans Bank',
                    'sequence' => 19,
                    'legnth' => '13',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'RCB',
                    'name' => 'RCBC',
                    'sequence' => 20,
                    'legnth' => '10,16',
                    'leading_zeroes' => 1
                ],
                [
                    'code' => 'RBN',
                    'name' => 'Robinsons Bank',
                    'sequence' => 21,
                    'legnth' => '15',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'SEC',
                    'name' => 'Security Bank',
                    'sequence' => 22,
                    'legnth' => '13',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'SCB',
                    'name' => 'Standard Chartered Bank',
                    'sequence' => 23,
                    'legnth' => '11',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'SBA',
                    'name' => 'Sterling Bank',
                    'sequence' => 24,
                    'legnth' => '15,16',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'UCP',
                    'name' => 'United Coconut Planters Bank (UCPB)',
                    'sequence' => 25,
                    'legnth' => '10,12',
                    'leading_zeroes' => 0
                ],
                [
                    'code' => 'UOB',
                    'name' => 'United Overseas Bank',
                    'sequence' => 26,
                    'legnth' => '12',
                    'leading_zeroes' => 0
                ],
            ]
        ];
        
        foreach($data as $method => $banks) {
            foreach ($banks as $key => $value) {
                PaynamicsDisbursementMethodBankCode::create([
                    'method' => $method, 
                    'code' => $value['code'], 
                    'name' => $value['name'], 
                    'sequence' => $value['sequence'], 
                    'legnth' => $value['legnth'], 
                    'leading_zeroes' => $value['leading_zeroes']
                ]);
            }
        }
    }
}
