<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TransactionBonus extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $fillable = ['member_id', 'class_id', 'class_type', 'type', 'acquired_amt', 'field1', 'field2'];
    
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
    
    public function scopeOfType($query, $type)
    {
        $query->where('type', $type);
    }
    
    public function scopeOfNotType($query, $type)
    {
        $query->where('type', '!=', $type);
    }
    
    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }
    
    public function membertype()
    {
        switch ($this->type)
        {
            case 'MP':
            case 'FP':
                return $this->hasOne(MembersPairing::class, 'id', 'class_id');
                break;
            case 'EB':
            case 'DR':
                return $this->hasOne(Member::class, 'id', 'class_id');
                break;
        }
    }
}
