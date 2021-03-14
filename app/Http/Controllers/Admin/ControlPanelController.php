<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Library\Modules\SettingLibrary;

class ControlPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requiredFields = $this->requiredFields();
        
        $data = array();
        foreach($requiredFields as $fields) {
            $data['model'][$fields] = SettingLibrary::retrieve($fields);
        }
        
        return view('admin.controlpanel')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requiredFields = $this->requiredFields();
        
        try {
            DB::beginTransaction();
            foreach ($request->only($requiredFields) as $key => $value) {
                SettingLibrary::save($key, $value);
            }
            
            DB::commit();
            return redirect()->back()->with('status-success', 'System control panel is updated!');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }
    
    private function requiredFields () 
    {
        return  [
            'encash_status', 
            'admin_fee', 
            'unilvl_personal', 
            'unilvl_1', 
            'unilvl_2', 
            'unilvl_3', 
            'unilvl_4', 
            'unilvl_5', 
            'unilvl_6', 
            'unilvl_7', 
            'unilvl_8', 
            'unilvl_9', 
            'unilvl_10', 
            'indirect_1', 
            'indirect_2', 
            'indirect_3', 
            'indirect_4', 
            'indirect_5', 
            'indirect_6', 
            'indirect_7', 
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
