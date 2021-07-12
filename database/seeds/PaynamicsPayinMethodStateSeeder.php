<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class PaynamicsPayinMethodStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $disabledPayin = [
            'bdootc',
            'ucpbotc',
            'mybinstall',
            'rcbcinstall',
            'rsbinstall',
            'bpiinstall',
            'mtbinstall',
            'hsbinstall',
            'bdoinstall',
            'etap',
            'dp',
            'br_rcbc_ph',
            'br_bdo_ph',
            'br_pnb_ph',
            'ucpbobp',
            'wechatpay',
            'paymaya',
            'pwn',
            'alipay',
            'pp'
        ];
        
        DB::table('paynamics_payin_methods')
                ->whereIn('method', $disabledPayin)
                ->update(['deleted_at' => \Carbon\Carbon::now()]);
    }
}
