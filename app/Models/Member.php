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
        'username', 'password', 'sponsor_id', 'firstname',
        'middlename', 'lastname', 'address', 'email',  'mobile',  'registration_code_id', 
        'must_change_password', 'birthdate'
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
    
    public function scopeSearch($query, $search)
    {
        $query->where('username', 'LIKE', '%' . $search . '%')
            ->orWhere('firstname', 'LIKE', '%' . $search . '%')
            ->orWhere('lastname', 'LIKE', '%' . $search . '%');
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
        return $this->hasMany(MembersPairing::class, 'member_id', 'id');
    }
    
    public function pairingsMP()
    {
        return $this->hasMany(MembersPairing::class, 'member_id', 'id')
                ->where('type', 'MP');
    }
    
    public function pairingsFP()
    {
        return $this->hasMany(MembersPairing::class, 'member_id', 'id')
                ->where('type', 'FP');
    }
        
    public function pairingsToday()
    {
        return $this->hasMany(MembersPairing::class, 'member_id', 'id')
                ->whereDate('created_at', date('Y-m-d'));
    }
    
    public function pairingsYesterday()
    {
        return $this->hasMany(MembersPairing::class, 'member_id', 'id')
                ->whereDate('created_at', date("Y-m-d", time() - 3600*24));
    }
    
    public function entry_code()
    {
        return $this->hasOne(RegistrationCode::class, 'id', 'registration_code_id');
    }
    
    public function sponsor()
    {
        return $this->hasOne(Member::class, 'id', 'sponsor_id');
    }
    
    public function pair_cycle()
    {
        return $this->hasOne(MembersPairCycle::class, 'id', 'pair_cycle_id');
    }
}
