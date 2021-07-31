<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Library\Modules\SettingLibrary;

/**
 * @group Admin/Admin Menu
 *
 */
class ControlPanelController extends Controller
{
    /**
     * Display a control panel form.
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
     * Store control panel settings.
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
            return redirect()->back()->with('status-success', 'Control panel is updated!');
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
            'direct_referral_bonus', 
            'encoding_bonus', 
            'max_pairing_ctr',
            'expiry_day',
            'starting_date'
        ];
    }
}
