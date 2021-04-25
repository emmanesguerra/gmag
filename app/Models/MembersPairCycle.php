<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MembersPairCycle extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

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
