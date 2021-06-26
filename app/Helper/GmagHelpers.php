<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helper;

/**
 * Description of CommonHelper
 *
 * @author alvin
 */

use Illuminate\Support\Facades\DB;
use App\Library\Modules\SettingLibrary;

class GmagHelpers {
    //put your code here
    
    public static function getPendingEncash()
    {
        $count = DB::table('members_encashment_requests')->where('status', 'WA')->whereNull('deleted_at')->count();
        if($count) {
            return '<span class="badge badge-primary" style="background-color: #3490dc;margin-left: 0;">'.$count.'</span>';
        }
        
        return '';
    }
    
    public static function getStartingDate()
    {
        return SettingLibrary::retrieve('starting_date');
    }
}
