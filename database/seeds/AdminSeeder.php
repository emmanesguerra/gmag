<?php

use Illuminate\Database\Seeder;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Goldermagtop',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('gmag12345'),
            'is_super' => 1,
        ]);
    }
}
