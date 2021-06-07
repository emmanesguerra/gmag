<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class GmagAccount extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $fillable = [
        'firstname', 'middlename', 'lastname', 'address1', 'address2', 'address3', 'email',  
        'mobile', 'birthdate', 'birthplace',
        'city', 'state', 'country', 'zip',
        'nature_of_work', 'nationality'
    ];
    
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
    
    public function primaryDocument()
    {
        return $this->hasOne(GmagAccountDocuments::class, 'account_id', 'id')->where('type', 1);
    }
    
    public function secondaryDocument1()
    {
        return $this->hasOne(GmagAccountDocuments::class, 'account_id', 'id')->where('type', 2);
    }
    
    public function secondaryDocument2()
    {
        return $this->hasOne(GmagAccountDocuments::class, 'account_id', 'id')->where('type', 3);
    }
}
