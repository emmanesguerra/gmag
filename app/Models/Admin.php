<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password', 'is_super'
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
