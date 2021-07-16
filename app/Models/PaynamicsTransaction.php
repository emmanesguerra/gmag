<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaynamicsTransaction extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'member_id', 'product_id', 'quantity', 'total_amount', 'transaction_date', 'transaction_type', 'honorary_member_id'
    ];
    
    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }
    
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
