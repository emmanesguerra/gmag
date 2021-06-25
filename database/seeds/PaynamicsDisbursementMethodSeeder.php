<?php

use Illuminate\Database\Seeder;
use App\Models\PaynamicsDisbursementMethod;

class PaynamicsDisbursementMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaynamicsDisbursementMethod::create([
            'method' => 'GCASH',
            'name' => 'GCASH',
            'sequence' => 1,
            'transaction_limit' => 100000
        ]);
        
        PaynamicsDisbursementMethod::create([
            'method' => 'CEBCP',
            'name' => 'CEBUANA BRANCHES',
            'sequence' => 2,
            'transaction_limit' => 30000
        ]);
        
        PaynamicsDisbursementMethod::create([
            'method' => 'PXP',
            'name' => 'PAYEXPRESS',
            'sequence' => 3,
            'transaction_limit' => 100000
        ]);
        
        PaynamicsDisbursementMethod::create([
            'method' => 'IBRTPP',
            'name' => 'INTERBANK REMITTANCE TRANSFER',
            'sequence' => 4,
            'transaction_limit' => 500000
        ]);
        
        PaynamicsDisbursementMethod::create([
            'method' => 'UBP',
            'name' => 'UNIONBANK',
            'sequence' => 5,
            'transaction_limit' => 500000
        ]);
        
        PaynamicsDisbursementMethod::create([
            'method' => 'IBBT',
            'name' => 'INTERBANK BATCH TRANSFER',
            'sequence' => 6,
            'transaction_limit' => 500000
        ]);
        
        PaynamicsDisbursementMethod::create([
            'method' => 'BDOSMCP',
            'name' => 'BDO BRANCHES, SM PAYMENT COUNTER BRANCHES PALAWAN EXPRESS BRANCHES, RD PAWNSHOP BRANCHES',
            'sequence' => 7,
            'transaction_limit' => 30000
        ]);
        
        PaynamicsDisbursementMethod::create([
            'method' => 'MLCP',
            'name' => 'M LHULLIER BRANCHES',
            'sequence' => 8,
            'transaction_limit' => 30000
        ]);
        
        PaynamicsDisbursementMethod::create([
            'method' => 'SBINSTAPAY',
            'name' => 'INSTAPAY',
            'sequence' => 9,
            'transaction_limit' => 50000
        ]);
        
        PaynamicsDisbursementMethod::create([
            'method' => 'GHCP',
            'name' => 'CIS BAYAD CENTER, LBC BRANCHES, MLHULLIER, PALAWAN EXPRESS',
            'sequence' => 10,
            'transaction_limit' => 25000
        ]);
        
        PaynamicsDisbursementMethod::create([
            'method' => 'AUCP',
            'name' => 'ASIA UNITED BANK BRANCHES, CAVITE UNITED RURAL BANK, RURAL BANK OF  ANGELES',
            'sequence' => 11,
            'transaction_limit' => 100000
        ]);
    }
}
