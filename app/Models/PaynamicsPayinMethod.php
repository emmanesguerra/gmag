<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaynamicsPayinMethod extends Model
{
    use SoftDeletes;
    
    protected $primaryKey = 'method';
    public $incrementing = false;
    
    protected $fillable = [
        'method', 'type', 'description', 'type_name'
    ];
}
