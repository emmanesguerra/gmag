<?php

use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Product::create([
            'type' => 'ACT',
            'code' => 'STARTER',
            'name' => 'STARTER PACKAGE',
            'price' => 1998,
            'product_value' => 1998,
            'flush_bonus' => 1,
            'display_icon' => 'starter_s.png',
            'registration_code_prefix' => 'ST'
        ]);
        
        Product::create([
            'type' => 'ACT',
            'code' => 'BRONZE',
            'name' => 'BRONZE PACKAGE',
            'price' => 5998,
            'product_value' => 5998,
            'flush_bonus' => 3,
            'display_icon' => 'bronze_s.png',
            'registration_code_prefix' => 'BR'
        ]);
        
        Product::create([
            'type' => 'ACT',
            'code' => 'SILVER',
            'name' => 'SILVER PACKAGE',
            'price' => 19998,
            'product_value' => 19998,
            'flush_bonus' => 10,
            'display_icon' => 'silver_s.png',
            'registration_code_prefix' => 'SL'
        ]);
        
        Product::create([
            'type' => 'ACT',
            'code' => 'GOLD',
            'name' => 'GOLD PACKAGE',
            'price' => 49998,
            'product_value' => 49998,
            'flush_bonus' => 25,
            'display_icon' => 'gold_s.png',
            'registration_code_prefix' => 'GL'
        ]);
    }
}
