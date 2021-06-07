<?php

use Illuminate\Database\Seeder;

use App\Models\Member;
use App\Models\MembersPlacement;
use App\Models\MembersPairCycle;
use App\Library\Modules\SettingLibrary;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $member = Member::create([
            'username' => 'goldenmagtop',
            'email' => 'goldenmagtop@gmail.com',
            'password' => Hash::make('gmag12345'),
            'sponsor_id' => 0,
            'firstname' => 'MALICTAV GMAG Enterprise',
            'middlename' => 'USA',
            'lastname' => 'Doing As Business',
            'address1' => 'Lorem ipsum dolor sit amet, consectetur adipiscing',
            'address2' => 'Lorem ipsum dolor sit amet, consectetur adipiscing',
            'mobile' => '+5590897035601',
            'city' => 'Makati',
            'country' => 'PH',
            'birhtdate' => '2005-01-01',
            'registration_code_id' => 0,
            'must_change_password' => 0,
        ]);
        
        if($member) {
            MembersPlacement::create([
                'member_id' => $member->id,
                'placement_id' => 0,
                'lft' => '1',
                'rgt' => 2,
                'lvl' => 1,
                'position' => 0,
                'product_id' => 4,
            ]);
            
            $cycle = MembersPairCycle::create([
                'member_id' => $member->id,
                'start_date' => Carbon\Carbon::now(),
                'max_pair' => SettingLibrary::retrieve('max_pairing_ctr'),
                'product_id' => 4,
            ]);
            
            $member->pair_cycle_id = $cycle->id;
            $member->save();
        }
    }
}
