<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberLog extends Model
{
    protected $fillable = ['log_in', 'ip_address', 'username'];
    
    public $timestamps = false;
    
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    
    public function scopeSearch($query, $search)
    {
        $query->where('username', 'LIKE', '%' . $search . '%');
    }
    
    public function member()
    {
        return $this->hasOne(Member::class);
    }
}
