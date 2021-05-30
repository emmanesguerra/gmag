<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PickupCenter extends Model
{
    use SoftDeletes;
    
    protected $primaryKey = 'code';
    public $incrementing = false;
    
    protected $fillable = [
        'code', 'description', 'sequence', 'type'
    ];
}