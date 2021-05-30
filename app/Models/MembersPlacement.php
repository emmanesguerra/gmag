<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembersPlacement extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'member_id', 'placement_id', 'lft', 'rgt', 'lvl', 'position', 'product_id'
    ];
    
    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }
    
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
