<?php

use Illuminate\Database\Seeder;

use App\Models\PickupCenter;

class PickupCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $primary = [
            [
                'code' => 'CBC',
                'desc' => 'CIS Bayad Center',
                'type' => 'GHCP'
            ],
            [
                'code' => 'LBC',
                'desc' => "LBC Express",
                'type' => 'GHCP'
            ],
            [
                'code' => 'PAL',
                'desc' => 'Palawan Express',
                'type' => 'GHCP'
            ],
            [
                'code' => 'MLF',
                'desc' => "ML Hullhier",
                'type' => 'GHCP'
            ],
            [
                'code' => 'POP',
                'desc' => 'AUB Branch',
                'type' => 'AUCP'
            ],
            [
                'code' => 'CUR',
                'desc' => 'Cavite United Rural Bank',
                'type' => 'AUCP'
            ],
            [
                'code' => 'RBP',
                'desc' => 'Rural Bank of Angeles',
                'type' => 'AUCP'
            ],
        ];
        
        $ctr = 1;
        foreach($primary as $p) {
            PickupCenter::create([
                'code' => $p['code'],
                'description' => $p['desc'],
                'sequence' => $ctr,
                'type' => $p['type']
            ]);
            $ctr++;
        }
    }
}
