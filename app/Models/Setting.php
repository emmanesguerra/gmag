<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Setting extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $auditExclude = [
        'created_by',
        'updated_by'
    ];
    
    
    protected $primaryKey = 'keyword';
    public $incrementing = false;
    
    protected $fillable = ['keyword', 'keyvalue'];
    
    
    /*
     * For audit tags
     */
    public function generateTags(): array
    {
        return ['displayToDashboard'];
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    
    public static function scopeDefaults($query, $params) {
        
        return $query->where('keyword', $params)->first();
    }
}
