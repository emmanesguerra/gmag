<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembersEncashmentRequest extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    
    protected $fillable = [
        'member_id', 
        'source', 
        'amount', 
        'disbursement_method', 
        'reference1', 
        'reference2', 
        'firstname', 
        'middlename', 
        'lastname', 
        'address1', 
        'address2',
        'city', 
        'state', 
        'country', 
        'zip', 
        'mobile', 
        'email'];
    
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
    
    public function pcenter()
    {
        return $this->hasOne(PickupCenter::class, 'code', 'reference1');
    }
    
    public function bank()
    {
        return $this->hasOne(PaynamicsDisbursementMethodBankCode::class, 'code', 'reference1');
    }
    
    public function disbursement()
    {
        return $this->hasOne(PaynamicsDisbursementMethod::class, 'method', 'disbursement_method');
    }
}
