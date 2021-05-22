<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaynamicsTransaction extends Model
{
    protected $fillable = [
        'member_id', 'product_id', 'quantity', 'total_amount', 'transaction_date'
    ];
}
