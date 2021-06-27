<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaynamicsEncashmentResp extends Model
{
    protected $fillable = [
        'encashment_id', 'request_id', 'hed_response_id', 'hed_response_code', 'hed_response_message',
        'det_response_id', 'det_response_code', 'det_response_message', 'det_processor_response_id'
    ];
}
