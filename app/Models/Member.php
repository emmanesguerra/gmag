<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    
    use Notifiable;

    protected $guard = 'member';

    protected $fillable = [
        'username', 'password', 'sponsor_id', 'firstname',
        'middlename', 'lastname', 'address1', 'address2', 'address3', 'email',  
        'mobile',  'registration_code_id', 
        'must_change_password', 'birthdate', 'has_credits',
        'city', 'state', 'country', 'zip',
        'nature_of_work', 'nationality'
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
    
    public function pair_cycles()
    {
        return $this->hasMany(MembersPairCycle::class, 'member_id', 'id');
    }
    
    public function latest_pair_cycle()
    {
        return $this->hasOne(MembersPairCycle::class, 'member_id', 'id')->latest();
    }
    
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'member_id', 'id');
    }
    
    public function transactionBonuses()
    {
        return $this->hasMany(TransactionBonus::class, 'member_id', 'id');
    }
    
    public function honorary()
    {
        return $this->hasOne(HonoraryMember::class, 'member_id', 'id')->latest();
    }
    
    public function disbursementDetails()
    {
        return $this->hasMany(MembersDisbursementDetail::class, 'member_id', 'id');
    }
    
    public function documents()
    {
        return $this->hasMany(MemberDocument::class, 'member_id', 'id');
    }
    
    public function primaryDocument()
    {
        return $this->hasOne(MemberDocument::class, 'member_id', 'id')->where('type', 1);
    }
    
    public function secondaryDocument1()
    {
        return $this->hasOne(MemberDocument::class, 'member_id', 'id')->where('type', 2);
    }
    
    public function secondaryDocument2()
    {
        return $this->hasOne(MemberDocument::class, 'member_id', 'id')->where('type', 3);
    }
}
