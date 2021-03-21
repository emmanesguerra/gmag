<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Library;

/**
 * Description of HierarchicalDB
 *
 * @author ai
 */
use Illuminate\Support\Facades\DB;

class HierarchicalDB {

    //put your code here
    protected $table;
    
    public function __construct($table) {
        $this->table = $table;
    }

    public function updateLftPlus($lft)
    {
        DB::table($this->table)
                ->where('lft', '>=', $lft)
                ->update(['lft' => DB::raw('lft+2')]);
    }
    
    public function updateRgtPlus($rgt)
    {
        DB::table($this->table)
                ->where('rgt', '>=', $rgt)
                ->update(['rgt' => DB::raw('rgt+2')]);
    }
    
    public function updateLftMinus($lft)
    {
        DB::table($this->table)
                ->where('lft', '>=', $lft)
                ->update(['lft' => DB::raw('lft-2')]);
    }
    
    public function updateRgtMinus($rgt)
    {
        DB::table($this->table)
                ->where('rgt', '>=', $rgt)
                ->update(['rgt' => DB::raw('rgt-2')]);
    }
    
    public function getLastRgt()
    {
        $rgt = DB::table($this->table)
                ->select('rgt')
                ->orderBy('rgt', 'desc')
                ->limit(1)
                ->first();
        
        if($rgt) {
            return $rgt->rgt;
        } else {
            return 0;
        }
    }
}
