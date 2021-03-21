<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;

class Member extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    use Notifiable;

    protected $guard = 'member';

    protected $fillable = [
        'username', 'email', 'password', 'sponsor_id', 'placement_id', 'lft', 'rgt', 'lvl', 'position', 'firstname',
        'middlename', 'middlename', 'lastname', 'address', 'email',  'mobile',  'registration_code_id', 
    ];

    protected $hidden = [
        'password', 'remember_token',
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
}
