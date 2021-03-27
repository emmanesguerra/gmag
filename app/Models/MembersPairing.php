<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembersPairing extends Model
{
    protected $fillable = [
        'member_id', 'lft_mid', 'rgt_mid', 'product_id', 'type'
    ];
}
