<?php

use Illuminate\Database\Seeder;

use App\Models\PaynamicsPayinMethod;

class PaynamicsPayinMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'type' => 'bank_otc',
                'type_name' => 'Bank Otc',
                'methods' => [
                    'bdootc' => 'Banco De Oro Bank Philippine Branches',
                    'pnbotc' => 'Philippine National Bank Branches',
                    'ucpbotc' => 'United Coconut Planters Bank Branches',
                ],
            ],
            [
                'type' => 'nonbank_otc',
                'type_name' => 'Non-Bank Otc',
                'methods' => [
                    'ecpay' => 'Ecpay Network Philippines',
                    'da5' => 'Direct Agents 5 Network Philippines',
                    'expresspay' => 'Expresspay Network Philippines',
                    'dp' => 'DragonPay Philippines',
                    '7eleven' => '711 Network Philippines',
                    'cliqq' => '711 Cliqq Network Philippines',
                    'ml' => 'Mlhuillier Pawnshop Network',
                    'ceb' => 'Cebuana Pawnshop Network',
                    'sm' => 'SM Bills Payment Network',
                    'truemoney' => 'True Money Network',
                    'posible' => 'Posible.net Network',
                    'etap' => 'Etap Network',
                ],
            ],
            [
                'type' => 'creditcard',
                'type_name' => 'Credit Card',
                'methods' => [
                    'cc' => 'Credit Card',
                ],
            ],
            [
                'type' => 'onlinebillspyament',
                'type_name' => 'Online Bills Payment',
                'methods' => [
                    'bdoobp' => 'BDO Online Bills Payment',
                    'pnbobp' => 'Philippine National Bank Online Bills Payment',
                    'ucpbobp' => 'United Coconut Planters Online Bills Payment',
                    'sbcobp' => 'Security Bank Online Bills Payment',
                ],
            ],
            [
                'type' => 'onlinebanktransfer',
                'type_name' => 'Online Bank Transfer',
                'methods' => [
                    'bn' => 'Bancnet Philippines',
                    'bpionline' => 'Bank of the Philippine Islands',
                    'ubponline' => 'Unionbank of the Philippines',
                    'br_bdo_ph' => 'BDO Online via Brankas',
                    'br_rcbc_ph' => 'RCBC Online via Brankas',
                    'br_pnb_ph' => 'PNB Online via Brankas',
                ],
            ],
            [
                'type' => 'wallet',
                'type_name' => 'Wallet',
                'methods' => [
                    'pp' => 'Paypal',
                    'pwn' => 'Paynamics Wallet Network',
                    'gc' => 'Gcash',
                    'paymaya' => 'Paymaya',
                    'coins' => 'Coins PH',
                    'grabpay' => 'Grabpay PH',
                    'alipay' => 'Alipay',
                    'wechatpay' => 'Wechat Pay',
                ],
            ],
            [
                'type' => 'installment',
                'type_name' => 'Installment',
                'methods' => [
                    'bdoinstall' => 'BDO Installment',
                    'hsbinstall' => 'HSBC Installment',
                    'mtbinstall' => 'Metrobank Installment',
                    'bpiinstall' => 'Bank of the Philippine Island Installment',
                    'rsbinstall' => 'Robinsons Bank Installment',
                    'rcbcinstall' => 'RCBC Bankard Installment',
                    'mybinstall' => 'Maybank Ezypay Installment',
                ],
            ]
        ];
        
        foreach($data as $index => $data) {
            foreach($data['methods'] as $method => $description) {
                PaynamicsPayinMethod::create([
                    'type' => $data['type'],
                    'type_name' => $data['type_name'],
                    'method' => $method,
                    'description' => $description,
                ]);
            }
        }
    }
}
