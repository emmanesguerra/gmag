<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MembersRegistrationCode extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'member_id', 'product_id', 'remarks', 'created_by', 'pincode1', 'pincode2'
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
        $query->where('is_used', $search['status'])
                ->where(function($q) use ($search) {
                    $q->where('pincode1', 'LIKE', '%' . $search['search'] . '%')
                      ->orWhere('pincode2', 'LIKE', '%' . $search['search'] . '%');
                });
    }
    
    /**
     * Get the product associated with the member codes.
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    
    /**
     * Get the creator associated with the member codes.
     */
    public function creator()
    {
        return $this->hasOne(Admin::class, 'id', 'created_by');
    }
}
