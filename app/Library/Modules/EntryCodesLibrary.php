<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Library\Modules;

/**
 * Description of EntryCodes
 *
 * @author alvin
 */

use Illuminate\Support\Facades\Auth;
use App\Models\RegistrationCode;
use App\Models\Product;

class EntryCodesLibrary {
    //put your code here
    public static function createEntryCodes(Product $product, int $memberId = null, int $count = 0, string $remarks = null, int $transactionId = null)
    {
        $data = array();
        for ($i = 0; $i < $count; $i++) {
            $data[] = [
                'assigned_to_member_id' => $memberId,
                'product_id' => $product->id,
                'transaction_id' => $transactionId,
                'remarks' => $remarks,
                'pincode1' => $product->registration_code_prefix . substr(strtoupper(bin2hex(random_bytes(10))), 0, 6),
                'pincode2' => substr(strtoupper(bin2hex(random_bytes(10))), 0, 8),
                'created_by' => Auth::id(),
                'created_at' => \Carbon\Carbon::now()
            ];
        }

        RegistrationCode::insertOrIgnore($data);    
    }
}
