<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaynamicsTransaction extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'member_id', 'product_id', 'quantity', 'total_amount', 'transaction_date'
    ];
}
