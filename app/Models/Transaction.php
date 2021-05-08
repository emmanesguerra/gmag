<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Transaction extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'member_id', 'product_id', 'firstname', 'lastname', 'email',
        'product_code', 'product_price', 'quantity', 'total_amount',
        'transaction_date', 'payment_method'
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
        $query->where('firstname', 'LIKE', '%' . $search . '%')
            ->orWhere('lastname', 'LIKE', '%' . $search . '%')
            ->orWhere('email', 'LIKE', '%' . $search . '%')
            ->orWhere('product_code', 'LIKE', '%' . $search . '%');
    }
    
    public function scopeOfPaymentMethod($query, $type)
    {
        $query->where('payment_method', $type);
    }
}
