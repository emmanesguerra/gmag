<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaynamicsDisbursementMethodBankCode extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'method', 'code', 'name', 'sequence', 'length', 'leading_zeroes'
    ];
}
