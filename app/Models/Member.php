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
        'username', 'email', 'password', 'sponsor_id', 'firstname',
        'middlename', 'middlename', 'lastname', 'address', 'email',  'mobile',  'registration_code_id', 
        'must_change_password'
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
    
    public function placement()
    {
        return $this->hasOne(MembersPlacement::class, 'member_id', 'id');
    }
    
    public function children()
    {
        return MembersPlacement::whereBetween('lft', [$this->placement->lft, $this->placement->rgt]);
    }
    
    public function pairings()
    {
        return $this->hasMany(MembersPairing::class, 'member_id', 'id')
                ->orderBy('created_at', 'desc');
    }
}
