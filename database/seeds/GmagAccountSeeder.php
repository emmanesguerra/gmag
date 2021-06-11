<?php

use Illuminate\Database\Seeder;

use App\Models\GmagAccount;
use App\Models\GmagAccountDocuments;

class GmagAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gmag = GmagAccount::create([
            'firstname' => 'MALICTAV GMAG Enterprise', 
            'middlename' => 'USA', 
            'lastname' => 'Doing As Business', 
            'address1' => 'Lorem ipsum dolor sit amet, cons', 
            'address2' => 'Lorem ipsum dolor sit amet, cons', 
            'address3' => 'Lorem ipsum dolor sit amet, cons', 
            'email' => 'goldenmagtop@gmail.com',  
            'mobile' => '+5590897035601', 
            'birthdate' => '2018-05-05', 
            'birthplace' => 'Makati PH',
            'city' => 'Makati', 
            'state' => '', 
            'country' => 'PH', 
            'zip' => '',
            'nature_of_work' => 'Marketing', 
            'nationality' => 'Filipino'
        ]); 
        
        $gmag->should_use = 1;
        $gmag->save();
        
        GmagAccountDocuments::create([
            'account_id' => $gmag->id, 
            'type' => '1', 
            'doc_type' => 'IDP_001', 
            'doc_id' => '1234567890', 
            'expiry_date' => '2027-06-08', 
            'proof' => ''
        ]);
    }
}
