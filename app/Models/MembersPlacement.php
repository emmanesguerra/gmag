<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembersPlacement extends Model
{
    protected $fillable = [
        'member_id', 'placement_id', 'lft', 'rgt', 'lvl', 'position', 'product_id'
    ];
}
