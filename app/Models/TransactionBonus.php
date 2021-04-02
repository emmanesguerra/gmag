<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionBonus extends Model
{
    protected $fillable = ['member_id', 'class_id', 'class_type', 'type', 'acquired_amt'];
}
