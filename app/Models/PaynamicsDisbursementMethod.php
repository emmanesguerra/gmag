<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaynamicsDisbursementMethod extends Model
{
    protected $primaryKey = 'method';
    public $incrementing = false;
    
    protected $fillable = [
        'method', 'name', 'sequence'
    ];
}
