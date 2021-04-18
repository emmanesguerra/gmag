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
            'price' => 1999,
            'product_value' => 1999,
            'flush_bonus' => 1,
            'display_icon' => 'starter_s.png',
            'registration_code_prefix' => 'ST'
        ]);
        
        Product::create([
            'type' => 'ACT',
            'code' => 'BRONZE',
            'name' => 'BRONZE PACKAGE',
            'price' => 4999,
            'product_value' => 4999,
            'flush_bonus' => 3,
            'display_icon' => 'bronze_s.png',
            'registration_code_prefix' => 'BR'
        ]);
        
        Product::create([
            'type' => 'ACT',
            'code' => 'SILVER',
            'name' => 'SILVER PACKAGE',
            'price' => 14999,
            'product_value' => 14999,
            'flush_bonus' => 5,
            'display_icon' => 'silver_s.png',
            'registration_code_prefix' => 'SL'
        ]);
        
        Product::create([
            'type' => 'ACT',
            'code' => 'GOLD',
            'name' => 'GOLD PACKAGE',
            'price' => 49999,
            'product_value' => 49999,
            'flush_bonus' => 7,
            'display_icon' => 'gold_s.png',
            'registration_code_prefix' => 'GL'
        ]);
    }
}
