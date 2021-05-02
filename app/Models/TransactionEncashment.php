<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TransactionEncashment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $fillable = ['member_id', 'amount', 'req_type', 'name', 'mobile'];
    
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
}
