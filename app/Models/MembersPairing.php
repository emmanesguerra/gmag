<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembersPairing extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'member_id', 'lft_mid', 'rgt_mid', 'product_id', 'product_value', 'type'
    ];
    
    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }
    
    public function lmember()
    {
        return $this->hasOne(Member::class, 'id', 'lft_mid');
    }
    
    public function rmember()
    {
        return $this->hasOne(Member::class, 'id', 'rgt_mid');
    }
    
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
