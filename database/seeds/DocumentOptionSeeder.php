<?php

use Illuminate\Database\Seeder;

use App\Models\DocumentOption;

class DocumentOptionSeeder extends Seeder
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
                'code' => 'IDP_001',
                'desc' => 'Passport',
            ],
            [
                'code' => 'IDP_002',
                'desc' => "Driver's License",
            ],
            [
                'code' => 'IDP_003',
                'desc' => 'Professional Regulation Commission (PRC) ID',
            ],
            [
                'code' => 'IDP_004',
                'desc' => "Voter's ID",
            ],
            [
                'code' => 'IDP_005',
                'desc' => 'Government Service Insurance System (GSIS) e-Card',
            ],
            [
                'code' => 'IDP_006',
                'desc' => 'Government Service Insurance System (GSIS) e-Card',
            ],
            [
                'code' => 'IDP_007',
                'desc' => 'Senior Citizen Card',
            ],
            [
                'code' => 'IDP_008',
                'desc' => 'Alien Certification of Registration/Immigrant Certificate of Registration',
            ],
            [
                'code' => 'IDP_009',
                'desc' => 'Integrated Bar of the Philippines ID Card',
            ],
            [
                'code' => 'IDP_010',
                'desc' => 'School ID Card',
            ],
            [
                'code' => 'IDP_011',
                'desc' => 'Tax Identification Number (TIN) Card',
            ],
            [
                'code' => 'IDP_012',
                'desc' => 'National Council for Disability (NCDA) ID Card',
            ],
        ];
        
        $secondary = [
            [
                'code' => 'IDS_001',
                'desc' => 'COMPANY IDs ISSUED BY PRIVATE ENTITIES OR INSTITUTIONS REGISTERED WITH OR SUPERVISED OR REGULATED EITHER BY THE BSP, SEC OR IC',
            ],
            [
                'code' => 'IDS_002',
                'desc' => 'National Bureau of Investigation (NBI) Clearance',
            ],
            [
                'code' => 'IDS_003',
                'desc' => 'Police Clearance',
            ],
            [
                'code' => 'IDS_004',
                'desc' => 'Postal ID',
            ],
            [
                'code' => 'IDS_005',
                'desc' => 'Barangay Certification',
            ],
            [
                'code' => 'IDS_006',
                'desc' => 'Overseas Workers Welfare Administration (OWWA) ID',
            ],
            [
                'code' => 'IDS_007',
                'desc' => 'OFW ID',
            ],
            [
                'code' => 'IDS_008',
                'desc' => 'Seaman’s Book',
            ],
            [
                'code' => 'IDS_009',
                'desc' => 'Government Office and GOCC ID, e.g. Armed forces of the Philippines (AFP ID), Home Development Mutual Fund (HDMF ID)',
            ],
            [
                'code' => 'IDS_010',
                'desc' => 'Department of Social Welfare and Development (DSWD) Certification',
            ],
            [
                'code' => 'IDS_011',
                'desc' => 'Philhealth Insurance Card ng Bayan (PHICB)',
            ],
        ];
        
        $ctr = 1;
        foreach($primary as $p) {
            DocumentOption::create([
                'code' => $p['code'],
                'description' => $p['desc'],
                'sequence' => $ctr,
                'is_primary' => true
            ]);
            $ctr++;
        }
        
        $ctr = 1;
        foreach($secondary as $p) {
            DocumentOption::create([
                'code' => $p['code'],
                'description' => $p['desc'],
                'sequence' => $ctr,
                'is_primary' => false
            ]);
            $ctr++;
        }
        
    }
}
