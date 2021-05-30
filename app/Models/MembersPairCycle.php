<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembersPairCycle extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $fillable = [
        'member_id', 'start_date', 'max_pair', 'product_id'
    ];
    
    /*
     * For audit tags
     */
    public function generateTags(): array
    {
        return ['displayToDashboard'];
    }
}
