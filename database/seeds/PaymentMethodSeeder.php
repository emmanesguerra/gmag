<?php

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'method' => 'ewallet',
            'name' => 'E-Wallet',
            'sequence' => 1
        ]);
        
        PaymentMethod::create([
            'method' => 'paynamics',
            'name' => 'Paynamics',
            'sequence' => 2
        ]);
    }
}
