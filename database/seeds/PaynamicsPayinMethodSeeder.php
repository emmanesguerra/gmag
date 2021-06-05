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
            'bank_otc' => [
                'bdootc' => 'Banco De Oro Bank Philippine Branches',
                'pnbotc' => 'Philippine National Bank Branches',
                'ucpbotc' => 'United Coconut Planters Bank Branches',
            ],
            'nonbank_otc' => [
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
            'creditcard' => [
                'cc' => 'Credit Card',
            ],
            'onlinebillspyament' => [
                'bdoobp' => 'BDO Online Bills Payment',
                'pnbobp' => 'Philippine National Bank Online Bills Payment',
                'ucpbobp' => 'United Coconut Planters Online Bills Payment',
                'sbcobp' => 'Security Bank Online Bills Payment',
            ],
            'onlinebanktransfer' => [
                'bn' => 'Bancnet Philippines',
                'bpionline' => 'Bank of the Philippine Islands',
                'ubponline' => 'Unionbank of the Philippines',
                'br_bdo_ph' => 'BDO Online via Brankas',
                'br_rcbc_ph' => 'RCBC Online via Brankas',
                'br_pnb_ph' => 'PNB Online via Brankas',
            ],
            'wallet' => [
                'pp' => 'Paypal',
                'pwn' => 'Paynamics Wallet Network',
                'gc' => 'Gcash',
                'paymaya' => 'Paymaya',
                'coins' => 'Coins PH',
                'grabpay' => 'Grabpay PH',
                'alipay' => 'Alipay',
                'wechatpay' => 'Wechat Pay',
            ],
            'installment' => [
                'bdoinstall' => 'BDO Installment',
                'hsbinstall' => 'HSBC Installment',
                'mtbinstall' => 'Metrobank Installment',
                'bpiinstall' => 'Bank of the Philippine Island Installment',
                'rsbinstall' => 'Robinsons Bank Installment',
                'rcbcinstall' => 'RCBC Bankard Installment',
                'mybinstall' => 'Maybank Ezypay Installment',
            ],
        ];
        
        foreach($data as $type => $value) {
            foreach($value as $method => $description) {
                PaynamicsPayinMethod::create([
                    'type' => $type,
                    'method' => $method,
                    'description' => $description,
                ]);
            }
        }
    }
}
