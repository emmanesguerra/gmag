<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionSeq extends Model
{
    protected $fillable = ['code', 'current_date', 'sequence'];
    
    public $timestamps = false;
}
