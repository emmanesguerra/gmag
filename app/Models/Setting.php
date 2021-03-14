<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $primaryKey = 'keyword';
    public $incrementing = false;
    
    protected $fillable = ['keyword', 'keyvalue'];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    
    public static function scopeDefaults($query, $params) {
        
        return $query->where('keyword', $params)->first();
    }
}
