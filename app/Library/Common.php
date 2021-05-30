<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Library;

/**
 * Description of Common
 *
 * @author alvin
 */
class Common {
    //put your code here
    public static function splitWord($str, $width, $length = PHP_INT_MAX)
    {
	$string = wordwrap($str, $width, "|");
        return explode("|", $string, $length);
    }
}
