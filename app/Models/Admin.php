<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;

class Admin extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /*
     * For audit tags
     */
    public function generateTags(): array
    {
        return ['displayToDashboard'];
    }
}
