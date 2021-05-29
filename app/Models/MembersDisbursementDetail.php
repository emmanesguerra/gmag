<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembersDisbursementDetail extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;
    
    /*
     * For audit tags
     */
    protected $auditExclude = [
        'created_by',
        'updated_by'
    ];
    public function generateTags(): array
    {
        return ['displayToDashboard'];
    }
    
    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }
}
