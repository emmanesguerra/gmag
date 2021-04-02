<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'type', 'code', 'name', 'price', 'product_value', 'flush_bonus', 'display_icon', 'registration_code_prefix'
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
        $query->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('code', 'LIKE', '%' . $search . '%')
            ->orWhere('price', 'LIKE', '%' . $search . '%');
    }
    
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }
    
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }
    
    public function setRegistrationCodePrefixAttribute($value)
    {
        $this->attributes['registration_code_prefix'] = strtoupper($value);
    }
}
