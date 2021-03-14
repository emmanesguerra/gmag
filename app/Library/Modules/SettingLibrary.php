<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SettingLibrary
 *
 * @author alvin
 */
namespace App\Library\Modules;

use App\Models\Setting;

class SettingLibrary {
    //put your code here
    
    public static function save($keyword, $value) {
        return Setting::updateOrCreate(['keyword' => $keyword], ['keyvalue' => $value]);
    }
    
    public static function retrieve($keyword) {
        $resp = Setting::find($keyword);
        return ($resp) ? $resp->keyvalue: null;
    }
}
