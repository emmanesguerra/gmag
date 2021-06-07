<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SettingSeeder::class,
            AdminSeeder::class,
            ProductSeeder::class,
            MemberSeeder::class,
            PaymentMethodSeeder::class,
            WalletTypeSeeder::class,
            PaynamicsDisbursementMethodSeeder::class,
            DocumentOptionSeeder::class,
            PickupCenterSeeder::class,
            PaynamicsPayinMethodSeeder::class,
            GmagAccountSeeder::class
        ]);
    }
}
