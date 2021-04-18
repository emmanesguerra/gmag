<?php

use Illuminate\Database\Seeder;

use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'keyword' => 'direct_referral_bonus',
            'keyvalue' => '.10'
        ]);
        
        Setting::create([
            'keyword' => 'encoding_bonus',
            'keyvalue' => '.01'
        ]);
    }
}
