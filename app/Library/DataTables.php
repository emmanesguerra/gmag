<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Library;

/**
 * Description of DataTables
 *
 * @author alvin
 */
use DB;

class DataTables {
    //put your code here
    
    public static function DataTableFiltersColSearch($model, $request, $columns, &$hasValue, &$totalFiltered) {
        $hasValue = 0;
        
        if(isset($request->columns)) {
            $model->where(function ($query) use ($columns, $request, &$hasValue, $hasColSearch) {
                if($hasColSearch) {
                    foreach($request->columns as $key => $data) {
                        if(!empty($data['search']['value'])) {
                            if(isset($columns[$key])) {
                                foreach($columns[$key] as $x => $field) {
                                    $query->where($field, 'like' ,'%'.$data['search']['value'].'%');
                                }
                                $hasValue = 1;
                            }
                        }
                    }
                }
            });
        }
        
        
        if(is_numeric($request->order[0]['column'])) {
            $model->orderBy($columns[$request->order[0]['column']][0], $request->order[0]['dir']);
        }
        
        
        $totalFiltered = $model->count();

        if($request->length > 0) {
            $model->offset($request->start);
            $model->limit($request->length);
        }
        return $model->get();
    }
    
    public static function DataTableFiltersNormalSearch($model, $request, $columns, &$hasValue, &$totalFiltered) {
        $hasValue = 0;
        
        if(isset($request->search)) {
            $model->where(function ($query) use ($columns, $request, &$hasValue) {
                foreach($columns as $field) {
                    $query->orWhere($field, 'like' ,'%'.$request->search['value'].'%');
                }
                $hasValue = 1;
            });
        }
        
        
        if(is_numeric($request->order[0]['column'])) {
            $model->orderBy($columns[$request->order[0]['column']], $request->order[0]['dir']);
        }
        
        
        $totalFiltered = $model->count();

        if($request->length > 0) {
            $model->offset($request->start);
            $model->limit($request->length);
        }
                
        return $model->get();
    }
}
