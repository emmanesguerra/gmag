<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentOption extends Model
{
    use SoftDeletes;
    
    protected $primaryKey = 'code';
    public $incrementing = false;
    
    protected $fillable = [
        'code', 'description', 'sequence', 'is_primary'
    ];
}
