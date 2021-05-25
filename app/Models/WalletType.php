<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletType extends Model
{
    protected $primaryKey = 'method';
    public $incrementing = false;
    
    protected $fillable = [
        'method', 'name', 'sequence'
    ];
}
