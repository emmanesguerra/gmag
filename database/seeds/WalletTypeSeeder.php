<?php

use Illuminate\Database\Seeder;
use App\Models\WalletType;

class WalletTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WalletType::create([
            'method' => 'matching_pairs',
            'name' => 'Matching Pairs',
            'sequence' => 1
        ]);
        
        WalletType::create([
            'method' => 'direct_referral',
            'name' => 'Direct Referral',
            'sequence' => 2
        ]);
        
        WalletType::create([
            'method' => 'encoding_bonus',
            'name' => 'Encoding Bonus',
            'sequence' => 3
        ]);
    }
}
